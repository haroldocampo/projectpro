<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Cost;
use AppBundle\Entity\Employee;
use AppBundle\Entity\EmployeePaymentType;
use AppBundle\Entity\PaymentType;
use AppBundle\Entity\Purchase;
use AppBundle\Entity\PurchaseItem;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\MimeType\FileinfoMimeTypeGuesser;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class PurchaseController extends Controller {

    /**
     * @Route("/api/purchases", name="apiPurchaseNew")
     * @Method("POST")
     */
    public function newAction(Request $request) {
//        $data = $request->getContent();
//        $params = json_decode($data, true);
//
//        $employeeId = $params['employeeId'];
//        $paymentTypeId = $params["paymentTypeId"];
//        $projectId = $params['projectId'];
//        $purchaseItems = $params["purchaseItems"];

        $employeeId = $request->request->get('employeeId');        
        $purchaseImage = $request->files->get('purchaseImage');
        $employeeId = $request->request->get('employeeId'); 
        $employeeName = $request->request->get('name');

        
        if (!$purchaseImage) {
            return new Response('No purchase image', 500);
        }

        $pis = $request->request->get('purchaseItems');
        $purchaseItems = json_decode($pis, true); // json string
        if (!$purchaseItems || empty($purchaseItems)) {
            return new Response('No purchase items: ' . $pis, 500);
        }

        $userId = $request->request->get('userId');

        $user = null;
        if ($userId) {
            $user = $this->getDoctrine()
                    ->getRepository('AppBundle:User')
                    ->find($userId);
        }

//        if (!$employeeId && !$user->hasRole(User::ROLE_ADMIN)) {
        if (!$employeeId) {
            // No company


            if ($user) {
                // User with no company

                $accountantEmail = $user->getAccountantEmail();
                if (!$accountantEmail) {
                    $accountantEmail = $user->getEmail();
                }
                $name = $user->getFirstName() . ' ' . $user->getLastName();
            } else {
                // iOS skipped user
                $accountantEmail = $request->request->get('accountantEmail');

                if (!filter_var($accountantEmail, FILTER_VALIDATE_EMAIL)) {
                    return new Response('Invalid accountant email. Make sure that you\'ve entered a valid one.', 500);
                }

                $name = $request->request->get('name');
            }

//            $attachment = \Swift_Attachment::fromPath($purchaseImage->getClientOriginalName());
//            $image = \Swift_Attachment::newInstance()
//            $pathToTemplate = $this->get('kernel')->getProjectDir() . '/web/template/temp/';
//            $fileName = 'purchase_image_' . uniqid() . '.jpg';
//            $filePath = $pathToTemplate . $fileName;
//            $purchaseImage->move($pathToTemplate, $fileName);
//            $attachment = \Swift_Attachment::fromPath($filePath, 'image/jpeg');
//            $attachment = \Swift_Attachment::fromPath($purchaseImage)
//                ->setFilename($purchaseImage->getClientOriginalName())
//                ->setContentType($purchaseImage->getClientMimeType());

            $attachment = \Swift_Attachment::fromPath($_FILES['purchaseImage']['tmp_name'])->setFilename($_FILES['purchaseImage']['name']);

            $message = (new \Swift_Message($name . " made a purchase"))
                    ->setFrom("fieldpurchases@projectprohub.com")
                    ->setTo($accountantEmail)
                    ->setBody(
                            $this->renderView(
                                    'email/purchase_made.html.twig', [
                                'purchaseItems' => $purchaseItems,
                                'user' => $name,
                                'paymentType' => $request->request->get('paymentTypeName'),
                                'project' => $request->request->get('projectName'),
                                'description' => $request->request->get('purchaseDescription'),
                                'amount' => $request->request->get('totalAmount')
                                    ]
                            ), 'text/html'
                    )
                    ->attach($attachment);

            $this->get('mailer')->send($message);

            return new JsonResponse(
                    [
                'status' => 'success',
                'message' => 'This purchase has been sent to your Accountant. Please notify him/her to look for an email from fieldpurchases@projectprohub.com',
                    ]
            );
        }

        $purchaser = $this->getDoctrine()
                ->getRepository('AppBundle:Employee')
                ->find($employeeId);

        $projectId = $request->request->get('projectId');
        if (!$projectId) {
            return new Response('No project id', 500);
        }
        $project = $this->getDoctrine()
                ->getRepository('AppBundle:Project')
                ->find($projectId);

        $vendorId = $request->request->get('vendorId');
        if (!$vendorId) {
            return new Response('No vendor id', 500);
        }
        $vendor = $this->getDoctrine()
            ->getRepository('AppBundle:Vendor')
            ->find($vendorId);

        if (!$project) {
            throw $this->createNotFoundException(
                    sprintf(
                            'No project found with id %s', $projectId
                    )
            );
        }

        $paymentTypeId = $request->request->get('paymentTypeId');
        if (!$paymentTypeId) {
            return new Response('No payment type id', 500);
        }

        $em = $this->getDoctrine()->getManager();

        // New Payment Type
        if ($paymentTypeId == 1) {
            // Create new payment type
            $paymentType = new PaymentType();
            $paymentType->setName($request->request->get('paymentTypeName'))
                    ->setCompany($purchaser->getCompany());
            $em->persist($paymentType);
            $em->flush();

            // Associate new payment type to employee
            $employeePaymentType = new EmployeePaymentType();
            $employeePaymentType->setEmployee($purchaser)
                    ->setPaymentType($paymentType);
            $em->persist($employeePaymentType);
            $em->flush();

            $admins = $this->getDoctrine()
                    ->getRepository('AppBundle:Employee')
                    ->findBy(['company' => $purchaser->getCompany()]);

            foreach ($admins as $admin) {
                if ($admin->hasRole(Employee::$ROLE_ADMIN) && $admin->getEnabled()) {
                    $message = (new \Swift_Message("A new Payment Type has been added to ProjectPro"))
                            ->setFrom("fieldpurchases@projectprohub.com")
                            ->setTo($admin->getUser()->getEmail())
                            ->setBody(
                            $this->renderView(
                                    'email/new_payment_type_notify.html.twig', [
                                'user' => $purchaser->getUser(),
                                'paymentType' => $paymentType,
                                'project' => $project
                                    ]
                            ), 'text/html'
                    );

                    $this->get('mailer')->send($message);
                }
            }
        } else {
            $paymentType = $this->getDoctrine()
                    ->getRepository('AppBundle:PaymentType')
                    ->find($paymentTypeId);
        }

        if (!$paymentType) {
            return new Response(sprintf(
                            'No payment type found with id %s', $paymentTypeId
                    ), 500);
//            throw $this->createNotFoundException(
//                sprintf(
//                    'No payment type found with id %s',
//                    $paymentTypeId
//                )
//            );
        }

        $salesTax = $request->request->get('salesTax');
        if (!$salesTax) {
//            return new Response('No sales tax', 500);
            $salesTax = 0;
        }

        $amount = $request->request->get('totalAmount');
        if (!$amount) {
            return new Response('No total purchase amount', 500);
        }

        $purchaseDate = $request->request->get('dop');

        $purchase = $em->getRepository('AppBundle:Purchase')
            ->create($project, Purchase::$STATUS_NOT_APPROVED, $salesTax, $purchaser, $paymentType, $amount, $purchaseImage, $purchaseDate, $vendor);

        // Get total amount
        $totalAmount = 0;
        foreach ($purchaseItems as $purchaseItem) {
            $totalAmount += $purchaseItem["amount"];
        }

        $costs = [];
        foreach ($purchaseItems as $purchaseItem) {
            $costId = $purchaseItem["costId"];
            $cost = $this->getDoctrine()
                    ->getRepository('AppBundle:Cost')
                    ->find($costId);

            if (!$cost) {
                // create new cost code
                $cost = new Cost();
                $cost->setProject($project)
                        ->setCodeNumber('N/A')
                        ->setExpenseType('N/A')
                        ->setDescription($purchaseItem['cost']['description'])
                        ->setHidden(true)
                        ->setBudgetAmount(0);

                $em->persist($cost);
            }

            if($cost->getNotify() == true){
                $isUnique = true;
                foreach($costs as $tCost){
                    if($tCost['cost']->getId() == $cost->getId()){
                        $isUnique = false;
                        break;
                    }
                }
                if($isUnique){
                    $costs[] = ['cost' => $cost, 'itemAmount' => $purchaseItem["amount"]];
                }
            }

            // Sales tax distribution
            $amount = $purchaseItem["amount"];
            $salesTaxPercentage = $amount / $totalAmount;
            $tax = $salesTax * $salesTaxPercentage;
            $taxedAmount = $amount + $tax;
            $memo = isset($purchaseItem['memo']) ? $purchaseItem['memo'] : '';
            $newPurchaseItem = $em->getRepository('AppBundle:PurchaseItem')
                ->create($amount, $cost, $tax, $taxedAmount, $memo, $purchase);
        }

        $em->flush();

        $this->notifyOverBudget($costs, $tmpAmount, $employeeName, $purchaser, $totalAmount);

        return new JsonResponse(
                [
            'status' => 'success',
            'message' => 'Created new purchase!',
                ]
        );
    }

    /**
     * @Route("/api/purchases/budgetcheck", name="apiPurchaseBudgetCheck")
     * @Method("POST")
     */
    public function checkBudgetAction(Request $request) {
        try {
            $employeeId = $request->request->get('employeeId');
            $employeeName = $request->request->get('name');
            $salesTax = $request->request->get('salesTax');
            $pis = $request->request->get('purchaseItems');
            $currentAmount = 0;

            $purchaseItems = json_decode($pis, true); // json string
            if (!$purchaseItems || empty($purchaseItems)) {
                return new JsonResponse(
                    [
                    'isOverBudget' => false,
                    'listItemsOverBudget' => []
                    ]
                );
            }

            $costs = [];

            // Get Total Amount
            $totalAmount = 0;
            foreach ($purchaseItems as $purchaseItem) {
                $totalAmount += $purchaseItem["amount"];
            }

            // Get Costs that is overbudget
            $overBudgetCosts = [];
            foreach ($purchaseItems as $purchaseItem) {
                $costId = $purchaseItem["costId"];
                $cost = $this->getDoctrine()
                        ->getRepository('AppBundle:Cost')
                        ->find($costId);

                if (!$cost) {
                    continue;
                }

                if($cost->getNotify() == true){
                    $budgetAmount = $cost->getBudgetAmount();
                    $existingPurchaseItems = $cost->getPurchaseItems();

                    // Get current amounts approved
                    foreach($existingPurchaseItems as $pi){
                        //if($pi->getPurchase()->getStatus() == 'STATUS_APPROVED'){
                            $currentAmount += $pi->getAmount();
                        //}
                    }

                    $amount = $purchaseItem["amount"];
                    $salesTaxPercentage = $amount / $totalAmount;
                    $tax = $salesTax * $salesTaxPercentage;
                    $taxedAmount = $amount + $tax;

                    $currentAmount += $taxedAmount;

                    if($currentAmount > $budgetAmount){
                        $overBudgetCosts[] = $cost->getCodeNumber() . ' ' .$cost->getDescription();
                    }
                }
            }

            return new JsonResponse(
                    [
                'isOverBudget' => count($overBudgetCosts) > 0,
                'listItemsOverBudget' => $overBudgetCosts
                    ]
            );
        } catch (\Exception $e) {
            return new JsonResponse(
                [
                'isOverBudget' => false,
                'listItemsOverBudget' => []
                ]
            );
        }
    }


    private function notifyOverBudget($costs, $amount, $employeeName, $purchaser, $totalAmount) {
        $overBudgetCosts = [];

        $emp = $purchaser->getUser();
        $employeeName = $emp->getFirstName() . ' ' . $emp->getLastName(); 

        foreach($costs as $cost){
            $budgetAmount = $cost['cost']->getBudgetAmount();
            $currentAmount = $cost['itemAmount'];
            $purchaseItems = $cost['cost']->getPurchaseItems();

            foreach($purchaseItems as $pi){
                //if($pi->getPurchase()->getStatus() == 'STATUS_APPROVED'){
                    $currentAmount += $pi->getAmount();
                //}
            }

            if($currentAmount > $budgetAmount){
                $overage = $currentAmount - $budgetAmount; 
                $overBudgetCosts[] = ['description' => $cost['cost']->getCodeNumber(), 'budget' => $budgetAmount, 'overage' => $overage];
            }
        }

        if(count($overBudgetCosts) > 0){
            $users = $this->getDoctrine()
                 ->getRepository('AppBundle:Employee')
                 ->findByCompanyRole($purchaser->getCompany(), 'ROLE_APPROVER');

            $overItems = "";
            foreach($overBudgetCosts as $obc){
                $budgetTmp = number_format((float)$obc['budget'], 2, '.', '');
                $overageTmp = number_format((float)$obc['overage'], 2, '.', '');
                $overItems .= "<tr>
                <td>".$obc['description']."</td>
                <td>$".$budgetTmp."</td>
                <td>$".$overageTmp."</td>
                </tr>";
            }

            $emailBody = "<h2 style=\"color: red;\">NOTICE: Budget has been exceeded</h2><br/>
            <p>".$employeeName." has submitted a purchase in the amount of $".$totalAmount." which has caused the total spent on the following cost item(s) to exceed the budget.</p><br/>
            <table style=\"border:none;\" cellspacing=\"0\" cellpadding=\"10\">
            <tbody>
            <tr>
                <td><b>COST CODE</b></td>
                <td><b>BUDGET</b></td>
                <td><b>OVERAGE</b></td>
            </tr>". $overItems. "
            </tbody>
            </table>
            <br>
            <p>Follow these steps to edit or decline this purchase:</p>
            <ol>
            <li>Log into ProjectPro</li>
            <li>Go to the Approver Dashboard</li>
            <li>Open project Fortress Storage</li>
            <li>Open the purchase submitted today in the amount of $".$totalAmount."</li>
            <li>Proceed to edit, approve, or decline</li>
            </ol>";

            foreach ($users as $user) {
                if (!$user->getEnabled()) { // Do not send an email if employee is not enabled
                    continue;
                }
                try{
                $message = (new \Swift_Message("ProjectPro Budget Exceeded"))
                        ->setFrom("projectpro.info@gmail.com")
                        ->setTo($user->getUser()->getEmail())
                        ->setBody($emailBody, 'text/html');
                        // ->setBody(
                        //         $this->renderView(
                        //             'email/budget_exceeded.html.twig', 
                        //             [
                        //                 //'costs' => $overBudgetCosts,
                        //                 //'user' => $employeeName,
                        //                 //'totalAmount' => $totalAmount
                        //             ]
                        //         ), 'text/html'
                        // );

                $this->get('mailer')->send($message);
                } catch (\Swift_SwiftException $exc){
                    throw $exc;
                }
            }
        }
    }

    /**
     * @Route("/api/purchases/{id}", name="apiPurchaseUpdate")
     * @Method({"PUT", "PATCH"})
     */
    public function updateAction($id, Request $request) {
        $data = $request->getContent();
        $params = json_decode($data, true);
        
        $em = $this->getDoctrine()->getManager();

        $purchase = $this->getPurchase($id);

        $projectId = $params['projectId'];
        $dateOfPurchase = $params['date_of_purchase'];
        $paymentTypeId = $params['paymentTypeId'];
        $purchaseItems = $params['items'];
        $totalAmount = $params['totalAmount'];
        $isSalesTaxOverride = $params['isSalesTaxOverride'];
        $qbImport = $params['qb_import'];      
        $isNewVendor = $params['isNewVendor'];   
        if($isNewVendor){            
            $vendorName = $params['vendor']['name'];            
            $vendorCompanyId = $params['vendor']['company'];
            $company = $this->get('pp_util.handler')->getCompany($vendorCompanyId);
            $vendor = $this->getDoctrine()
            ->getRepository('AppBundle:Vendor')
            ->create($company, $vendorName);

            $purchaserUser = $this->getDoctrine()
                ->getRepository('AppBundle:Employee')
                ->find($params['vendor']['purchaser'])
                ->getUser();

            $admins = $this->getDoctrine()
                ->getRepository('AppBundle:Employee')
                ->findByCompanyRole($company, 'ROLE_ADMIN');
            foreach ($admins as $admin) {
                $message = (new \Swift_Message("A new Vendor has been added to ProjectPro"))
                // ->setFrom("fieldpurchases@projectprohub.com")
                ->setFrom("projectpro.info@gmail.com")
                ->setTo($admin->getUser()->getEmail())
                ->setBody(
            $this->renderView(
                    'email/new_vendor.html.twig',
                [
                    'purchaserFirstName' => $purchaserUser->getFirstName(),
                    'purchaserLastName'  => $purchaserUser->getLastName(),
                    'adminFirstName'     => $admin->getUser()->getFirstName(),
                    'adminLastName'      => $admin->getUser()->getLastName(),
                    'vendorName'         => $vendor->getName()
                    ]
                ),
                'text/html'
            );
                $this->get('mailer')->send($message);
            }
        }else{
            $vendor = $this->getDoctrine()
                ->getRepository('AppBundle:Vendor')
                ->find($params['vendor']['id']);             
        }
          
        //$totalAmount = 0;

        foreach ($purchaseItems as $pi) {
            $piEntity = $this->getDoctrine()
                    ->getRepository('AppBundle:PurchaseItem')
                    ->find($pi['id']);

            $cost = $this->getDoctrine()
                    ->getRepository('AppBundle:Cost')
                    ->find($pi['cost']['id']);

            if ($cost->getHidden()) {
                $cost->setDescription($pi['cost']['description']);
            }

            // Round by 4 Decimal Places and output 2 Decimal Place
            //$amount = number_format((float)round($pi['amount'],2), 2, '.', '');
            $amount = $pi['amount'];
            $memo = isset($pi['memo']) ? $pi['memo'] : '';

            $purchase = $piEntity->getPurchase();
            
            $purchase->setIsOverrideSalesTax($isSalesTaxOverride);
            
            if($isSalesTaxOverride) {
                $piEntity->setTaxedAmount($amount);
            }
            
            $piEntity->setCost($cost)
                    ->setAmount($amount)
                    ->setMemo($memo);

            //$totalAmount += $pi['amount'];
        }

        $project = $this->getDoctrine()
                ->getRepository('AppBundle:Project')
                ->find($projectId);
        $paymentType = $this->getDoctrine()
                ->getRepository('AppBundle:PaymentType')
                ->find($paymentTypeId);

        // $purchase->setProject($project)
        //         ->setPaymentType($paymentType)
        //         ->setTotalAmount($totalAmount)
        //         ->setDateOfPurchase(new \DateTime($dateOfPurchase));

        $purchase = $this->getDoctrine()
            ->getRepository('AppBundle:Purchase')
            ->edit($purchase->getId(), $project, $paymentType, $totalAmount, $dateOfPurchase, $qbImport,$vendor);

        $em->flush();

        if($qbImport == 'ENABLED')
            $purchase = $this->getDoctrine()
            ->getRepository('AppBundle:Purchase')
            ->toggleImport($purchase->getId(), Purchase::$IMPORT_PENDING);
        
        $json = $this->get('pp_util.handler')->serialize(['purchase'=>$purchase,'isNewVendor'=>$isNewVendor]);

        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @Route("/api/purchases/{id}/approve", name="apiPurchaseApprove")
     */
    public function approveAction($id) {
        $params = $this->getRequest();
        $employee = $this->getDoctrine()
            ->getRepository('AppBundle:Employee')
            ->find($params['employeeId']);
        // $em = $this->getDoctrine()->getManager();                
        // $purchase = $this->getPurchase($id);
        // $purchase->setStatus(Purchase::$STATUS_APPROVED)
        //         ->setDateApproved(new \DateTime())
        //         ->setApprover($employee);
        // $em->flush();
        $purchase = $this->getDoctrine()
            ->getRepository('AppBundle:Purchase')
            ->approve($id,$employee);   
        if(is_null($purchase)) {
            throw $this->createNotFoundException(
                    sprintf('No purchase found with id %s', $id)
            );
        }        
        return new JsonResponse("Approved!");
    }

    /**
     * @Route("/api/purchases/{id}/decline", name="apiPurchaseDecline")
     */
    public function declineAction($id) {
        $params = $this->getRequest();
        $employee = $this->getDoctrine()
            ->getRepository('AppBundle:Employee')
            ->find($params['employeeId']);
        // $em = $this->getDoctrine()->getManager();
        // $purchase = $this->getPurchase($id);
        // $purchase->setStatus(Purchase::$STATUS_DECLINED)
        //         ->setDateDeclined(new \DateTime())
        //         ->setComments($params['comment'])
        //         ->setDecliner($employee);
        // $em->flush();
        $purchase = $this->getDoctrine()
            ->getRepository('AppBundle:Purchase')
            ->decline($id,$employee,$params['comment']);   

        $purchaserUser = $purchase->getPurchaser()->getUser();
        
        if(!$employee) {
            $tmpPurchaseDecliner = $this->getDoctrine()
                ->getRepository('AppBundle:Employee')
                ->find(3);
            $purchase->setDecliner($tmpPurchaseDecliner);
            
            $purchaseDecliner = $tmpPurchaseDecliner->getUser();
        } else {
            $purchaseDecliner = $purchase->getDecliner()->getUser();
        }
        
        

        $message = (new \Swift_Message("Purchase Declined"))
                ->setFrom("fieldpurchases@projectprohub.com")
                ->setTo($purchaserUser->getEmail())
                //->setTo('haroldocampo@live.com')
                ->setBody(
                $this->renderView(
                        'email/purchase_decline.html.twig', [
                    'purchaserFirstName' => $purchaserUser->getFirstName(),
                    'purchaserLastName'  => $purchaserUser->getLastName(),
                    'declinerFirstName'  => $purchaseDecliner->getFirstName(),
                    'declinerLastName'   => $purchaseDecliner->getLastName(),
                    'purchaseItems'      => $purchase->getPurchaseItems(),
                    'dateDeclined'       => $purchase->getDateDeclined(),
                    'amount'             => $purchase->getTotalAmount(),
                    'comments'           => $purchase->getComments()
                        ]
                ), 'text/html'
        );

        $this->get('mailer')->send($message);

        return new JsonResponse("Declined!");
    }

    /**
     * @Route("/api/purchaseItems", name="apiPurchaseItemNew")
     * @Method("POST")
     */
    public function newItemAction(Request $request) {
        $params = $this->getRequest();

        $amount = $params['amount'];
        $memo = isset($params['memo']) ? $params['memo'] : '';
        $purchaseId = $params['purchaseId'];
        $purchase = $this->getDoctrine()
                ->getRepository('AppBundle:Purchase')
                ->find($purchaseId);
        if (!$purchase) {
            throw $this->createNotFoundException(
                    sprintf(
                            'No purchase found with id %s', $purchaseId
                    )
            );
        }

        $costId = $params['costId'];
        $cost = $this->getDoctrine()
                ->getRepository('AppBundle:Cost')
                ->find($costId);
        if (!$cost) {
            throw $this->createNotFoundException(
                    sprintf(
                            'No cost found with id %s', $costId
                    )
            );
        }

        $em = $this->getDoctrine()->getManager();

        $pItem = $em->getRepository('AppBundle:PurchaseItem')
            ->create($amount, $cost, 0, $amount, $memo, $purchase);

        $json = $this->get('pp_util.handler')->serialize($pItem);

        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @Route("/api/purchases/{id}/vendor", name="apiSetPurchaseVendor")
     * @Method("POST")
     */
    public function setVendorAction($id,Request $request) {
        $params = $this->getRequest();

        $vendorId =$params['vendor'];        

        $purchase = $this->getDoctrine()
                ->getRepository('AppBundle:Purchase')
                ->find($id);

        $vendor = $this->getDoctrine()
                ->getRepository('AppBundle:Vendor')
                ->find($vendorId);
        if (!$purchase) {
            throw $this->createNotFoundException(
                    sprintf(
                            'No purchase found with id %s', $id
                    )
            );
        }
        if (!$purchase) {
            throw $this->createNotFoundException(
                    sprintf(
                            'No vendor found with id %s', $vendorId
                    )
            );
        }

        $em = $this->getDoctrine()->getManager();
        $purchase->setVendor($vendor);
        $em->persist($purchase);
        $em->flush();                

        $json = $this->get('pp_util.handler')->serialize($purchase);

        return new JsonResponse($json, 200, [], true);
    }

//    /**
//     * @Route("/api/purchaseItems/{id}", name="apiPurchaseItemUpdate")
//     * @Method({"PUT", "PATCH"})
//     */
//    public function updateItemAction() {
//
//    }

    /**
     * @Route("/api/purchaseItems/{id}", name="apiPurchaseItemDelete")
     * @Method("DELETE")
     */
    public function deleteItemAction($id) {
        // $purchase = $this->getDoctrine()
        //         ->getRepository('AppBundle:PurchaseItem')
        //         ->find($id);
        $deleted = $this->getDoctrine()
            ->getRepository('AppBundle:PurchaseItem')
            ->delete($id);
        if (is_null($deleted)) {
            throw $this->createNotFoundException(
                    sprintf(
                            'No purchase found with id %s', $id
                    )
            );
        }
        
        // $em = $this->getDoctrine()->getManager();
        // $em->remove($purchase);
        // $em->flush();


        return new JsonResponse('Deleted purchase ' . $id);
    }

    /**
     * @Route("/api/purchase/{id}/associatepurchaseclass", name="apiAssociatePurchaseClass")
     * @Method("POST")
     */
    public function associateClassAction($id) {
        $params = $this->getRequest();

        $purchaseClassId = $params['classId'];
        $purchase = $this->getDoctrine()
            ->getRepository('AppBundle:PurchaseItem')
            ->associateClass($id, $purchaseClassId);


        return new JsonResponse('Updated purchase ' . $purchase->getId());
    }

    /**
     * @Route("/api/purchase/{id}", name="apiPurchaseDelete")
     * @Method("DELETE")
     */
    public function deleteAction($id) {
       
        $deleted = $this->getDoctrine()
            ->getRepository('AppBundle:Purchase')
            ->delete($id);

        if (is_null($deleted)) {
                throw $this->createNotFoundException(
                        sprintf(
                                'No purchase found with id %s', $id
                        )
                );
        }

        return new JsonResponse('Deleted purchase ' . $id);
    }

    /**
     * @Route("/api/company/{id}/purchases", name="apiCompanyPurchaseList")
     * @Method("GET")
     */
    public function companyListAction($id, Request $request) {
        $dateStart = !is_null($request->query->get('dateStart')) ? date('Y-m-d',strtotime($request->query->get('dateStart')) ) : null;
        $dateEnd = !is_null($request->query->get('dateEnd')) ? date('Y-m-d',strtotime($request->query->get('dateEnd')) ) : null;        
        
        $company = $this->getDoctrine()
                ->getRepository('AppBundle:Company')
                ->find($id);

        if (!$company) {
            throw $this->createNotFoundException(
                    sprintf(
                            'No company found with id %s', $id
                    )
            );
        }

        $projects = $this->getDoctrine()
                ->getRepository('AppBundle:Project')
                ->findBy(['company' => $company]);

        $projectPurchases = array();
        foreach ($projects as $project) {
            if(!is_null($dateStart) && !is_null($dateEnd)){
                $purchases = $project->getPurchasesBetweenDate($dateStart, $dateEnd);                
            }           
            else{
                $purchases = $project->getPurchases();                             
            }
                
            foreach ($purchases as $purchase) {
                $projectPurchases[] = $purchase;
            }
        }

        $json = $this->get('pp_util.handler')->serialize(['purchases' => $projectPurchases]);

        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @Route("/api/company/{id}/unapprovedpurchases", name="apiCompanyPurchaseListUnapproved")
     * @Method("GET")
     */
    public function companyListUnapprovedAction($id, Request $request) {
        
        $company = $this->getDoctrine()
                ->getRepository('AppBundle:Company')
                ->find($id);

        if (!$company) {
            throw $this->createNotFoundException(
                    sprintf(
                            'No company found with id %s', $id
                    )
            );
        }

        $projects = $this->getDoctrine()
                ->getRepository('AppBundle:Project')
                ->findBy(['company' => $company]);

        $projectPurchases = array();
        foreach ($projects as $project) {
            $purchases = $project->getPurchases();
            foreach ($purchases as $purchase) {
                if ($purchase->getStatus() == 'STATUS_APPROVED' && $purchase->getMatchedImportedTransaction() == null 
                    && $purchase->getDateExported() == null) {
                    $projectPurchases[] = $purchase;
                }
            }
        }                
        
        $json = $this->get('pp_util.handler')->serialize(['purchases' => $projectPurchases]);

        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @Route("/api/company/{id}/approver/purchases", name="apiCompanyPurchaseListApprover")
     * @Method("GET")
     */
    public function companyListApproverAction($id, Request $request) {
        $company = $this->getDoctrine()
                ->getRepository('AppBundle:Company')
                ->find($id);

        $projects = $this->getDoctrine()
                ->getRepository('AppBundle:Project')
                ->findBy(['company' => $company]);

        $results = array();
        foreach ($projects as $project) {
            $projectPurchases = array();
            $purchases = $project->getPurchases();

            foreach ($purchases as $purchase) {
                if($purchase->getDateImported() != null || $purchase->getDateExported() != null) { // Do not load purchase if exported/imported
                    continue;
                }
                $projectPurchases[] = $purchase;
            }
            $results[] = ['id' => $project->getId(), 'project' => $project, 'purchases' => $projectPurchases];
        }

        $json = $this->get('pp_util.handler')->serialize(['projects' => $results]);

        return new JsonResponse($json, 200, [], true);
    }
    
//    /**
//     * @Route("/api/company/{id}/approver/purchasestest", name="apiCompanyPurchaseListApproverTest")
//     * @Method("GET")
//     */
//    public function companyListApproverTestAction($id, Request $request) {
//        $company = $this->getDoctrine()
//                ->getRepository('AppBundle:Company')
//                ->find($id);
       
//        $query = $this->getDoctrine()->getManager()->createQuery("SELECT proj, pur "
//                . "FROM AppBundle:Project proj "
//                . "LEFT JOIN proj.purchases pur "
//                . "JOIN proj.company co "
//                . "WHERE co.id = :companyId "
//                . "GROUP BY proj.id, pur.project");
       
//        $query->setParameter('companyId', $company->getId());

//        $json = $this->get('pp_util.handler')->serialize(['projects' => $query->getResult()]);

//        return new JsonResponse($json, 200, [], true);
//    }

    /**
     * @Route("/api/company/resetdemo", name="apiCompanyResetDemo")
     * @Method("GET")
     */
    public function companyResetDemoAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $company = $this->getDoctrine()
                ->getRepository('AppBundle:Company')
                ->find(79);

        if (!$company) {
            throw $this->createNotFoundException(
                    sprintf(
                            'No company found with id %s', $id
                    )
            );
        }

        $projects = $this->getDoctrine()
                ->getRepository('AppBundle:Project')
                ->findBy(['company' => $company]);

        $projectPurchases = array();
        foreach ($projects as $project) {
            $purchases = $project->getPurchases();
                
            $this->resetTransactions($company);
            foreach ($purchases as $key => $_purchase) {
                //$purchase = new Purchase();
                $purchase = $purchases[$key];
                $purchase->setDateImported(null)
                ->setDateExported(null)
                ->setDateDeclined(null)
                ->setDateApproved(null)
                ->setStatus('STATUS_NOT_APPROVED');

                // $it = $purchase->getMatchedImportedTransaction();

                // if(isset($it)){
                //     $purchase->setMatchedImportedTransaction(null);
                //     $em->flush();
                //     //var_dump($it->getId());
                //     //$this->getDoctrine()->getRepository('AppBundle:ImportedTransaction')->delete($it->getId());
                    
                // }
                $em->flush();
            }
            $this->resetDeleteTransactions($company);
        }

        $em->flush();

        $json = $this->get('pp_util.handler')->serialize(true);

        return new JsonResponse($json, 200, [], true);
    }

    private function resetTransactions($company){
        $em = $this->getDoctrine()->getManager();
        $its = $this->getDoctrine()->getRepository('AppBundle:ImportedTransaction')->findBy(['company' => $company]);

        $sql = " 
        UPDATE purchase p 
        JOIN project pr on pr.id = p.project_id
        SET p.imported_transaction_id = null
        where pr.company_id = 79
        ";

        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        //$stmt->fetchAll();
            
        foreach($its as $key => $_it){
            $it = $its[$key];
            $this->getDoctrine()->getRepository('AppBundle:ImportedTransaction')->find($it->getId())->setMatchedPurchase(null);
        }

        $em->flush();
    }

    private function resetDeleteTransactions($company){
        $em = $this->getDoctrine()->getManager();
        $its = $this->getDoctrine()->getRepository('AppBundle:ImportedTransaction')->findBy(['company' => $company]);
        
        foreach($its as $key => $_it){
            $it = $its[$key];
            $this->getDoctrine()->getRepository('AppBundle:ImportedTransaction')->delete($it->getId());
        }

        //$em->flush();
    }

    /**
     * @Route("/api/company/{id}/approver/unapprovedpurchases", name="apiCompanyPurchaseListApproverUnapproved")
     * @Method("GET")
     */
    public function companyListApproverUnapprovedAction($id, Request $request) {
        $company = $this->getDoctrine()
                ->getRepository('AppBundle:Company')
                ->find($id);

        $projects = $this->getDoctrine()
                ->getRepository('AppBundle:Project')
                ->findBy(['company' => $company]);

        $results = array();
        foreach ($projects as $project) {
            $projectPurchases = array();
            $purchases = $project->getPurchases();

            foreach ($purchases as $purchase) {
                if($purchase->getDateImported() != null || $purchase->getDateExported() != null) { // Do not load purchase if exported/imported
                    continue;
                }
                
                if ($purchase->getStatus() == 'STATUS_NOT_APPROVED') {
                    $projectPurchases[] = $purchase;
                }
            }
            $results[] = ['id' => $project->getId(), 'project' => $project, 'purchases' => $projectPurchases];
        }

        $json = $this->get('pp_util.handler')->serialize(['projects' => $results]);

        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @Route("/api/download/ccStatementTemplate", name="apiDownloadCCStatementTemplate")
     * @Method("GET")
     */
    public function downloadCCStatementTemplateAction(Request $request) {
        $pathToTemplate = $this->get('kernel')->getProjectDir() . '/web/template/';
        $fileName = 'cc_statement_template.xlsx';

        $response = new BinaryFileResponse($pathToTemplate . $fileName);
        $mimeTypeGuesser = new FileinfoMimeTypeGuesser();

        if ($mimeTypeGuesser->isSupported()) {
            // Guess the mimetype of the file according to the extension of the file
            $response->headers->set('Content-Type', $mimeTypeGuesser->guess($pathToTemplate . $fileName));
        } else {
            // Set the mimetype of the file manually, in this case for a text file is text/plain
            $response->headers->set('Content-Type', 'text/plain');
        }

        $response->setContentDisposition(
                ResponseHeaderBag::DISPOSITION_ATTACHMENT, $fileName
        );

        return $response;
    }

    /**
     * @param $id
     * @return Purchase|null|object
     */
    private function getPurchase($id) {
        $purchase = $this->getDoctrine()
                ->getRepository('AppBundle:Purchase')
                ->find($id);

        if (!$purchase) {
            throw $this->createNotFoundException(
                    sprintf('No purchase found with id %s', $id)
            );
        }

        return $purchase;
    }

    /**
     * @param $id
     * @return string
     */
    private function projectNotFound($id) {
        return sprintf(
                'No project found with id %s', $id
        );
    }

    private function getRequest() {
        $params = array();
        $content = $this->container->get('request_stack')->getCurrentRequest()->getContent();

        if (!empty($content)) {
            $params = json_decode($content, true); // 2nd param to get as array
        }

        return $params;
    }

}
