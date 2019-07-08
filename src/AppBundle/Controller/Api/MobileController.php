<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Cost;
use AppBundle\Entity\Purchase;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class MobileController extends Controller {
    // for post
    //$request->request->get('foo')
    // for get
    //$request->get('foo');

    /**
     * @Route("/mobile/verify", name="mobileVerify")
     * @Method("POST")
     */
    public function verifyAction(Request $request) {
        $email = $request->request->get('email');
        $password = $request->request->get('password');
        $companyId = 0;
        $employeeId = 0;
        $userId = 0;
        $companies = [];

        $user_manager = $this->get('fos_user.user_manager');
        $factory = $this->get('security.encoder_factory');
        $user = $user_manager->findUserByUsername($email);
        if (!$user) {
            return new JsonResponse([
                'status' => 'missing'
            ]);
        }
        if (!$user->isEnabled()) {
            return new JsonResponse([
                'status' => 'disabled'
            ]);
        }
        $userId = $user->getId();
        $encoder = $factory->getEncoder($user);

        $status = ($encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt())) ? 'success' : 'error';

        if ($status == 'success') {
            $employee = $this->getDoctrine()
                    ->getRepository('AppBundle:Employee')
                    ->findOneBy(['user' => $user]);

            if (isset($employee)) {
                $companyId = $employee->getCompany()->getId();
                $employeeId = $employee->getId();

                $user = $employee->getUser();

                $employments = $user->getEmployments();

                foreach ($employments as $employment) {
                    if ($employment->getEnabled()) {
                        array_push(
                            $companies,
                            [
                                'companyId' => $employment->getCompany()->getId(),
                                'name' => $employment->getCompany()->getName(),
                                'employeeId' => $employment->getId()
                            ]
                        );
                    }
                }
            }

            $isSuperAdmin = false;
            if ($user->hasRole(User::ROLE_ADMIN)) {
                $isSuperAdmin = true;
                $companies = [];
                $allCompanies = $this->getDoctrine()
                    ->getRepository('AppBundle:Company')->findBy([], ['name' => 'ASC']);
                foreach ($allCompanies as $company) {
                    array_push(
                        $companies,
                        [
                            'companyId' => $company->getId(),
                            'name' => $company->getName(),
                            'employeeId' => null
                        ]
                    );
                }
            }

            return new JsonResponse(['status' => $status, 'companyId' => $companyId, 'userId' => $userId, 'employeeId' => $employeeId, 'companies' => $companies, 'isSuperAdmin' => $isSuperAdmin]);
        } else {
//            return new Response('Unable to verify', 500);
            return new JsonResponse([
                'status' => 'invalid'
            ]);
        }
    }

    /**
     * @Route("/mobile/purchases", name="apiEmployeePurchaseList")
     * @Method("GET")
     */
    public function purchaseListAction(Request $request) {
        $id = $request->query->get('userId');
        $isSuperAdmin = 'false';
        $companyId = $request->query->get('companyId');
        $purchaser = $this->getDoctrine()
                ->getRepository('AppBundle:Employee')
                ->find($id);

        $helper = $this->container->get('vich_uploader.templating.helper.uploader_helper');

        if (!$isSuperAdmin || $isSuperAdmin === 'false') {
            $purchases = $this->getDoctrine()
                ->getRepository('AppBundle:Purchase')
                ->findBy(['purchaser' => $purchaser, 'status' => Purchase::$STATUS_NOT_APPROVED]);

            $projectPurchases = [];
            foreach ($purchases as $purchase) {
                $dateApproved = $purchase->getDateApproved();
                if(isset($dateApproved)){
                    continue; // Skip approved
                }

                $projectPurchases[] = ['id' => $purchase->getId(),
                    'amount' => $purchase->getAmount(),
                    'totalPurchaseAmount' => $purchase->getTotalAmount(),
                    'date' => $purchase->getDateOfPurchase(),
                    'imageUrl' => $helper->asset($purchase, 'imageFile'),
//                'imageUrl' => $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath() . $helper->asset($purchase, 'imageFile'),
                    'data' => $purchase];
            }
        } else {
            $company = $this->getDoctrine()
                ->getRepository('AppBundle:Company')
                ->find($companyId);

            $projects = $this->getDoctrine()
                ->getRepository('AppBundle:Project')
                ->findBy(['company' => $company]);

            $projectPurchases = array();
            foreach ($projects as $project) {
                $purchases = $project->getPurchases();
                foreach ($purchases as $purchase) {
                    $dateApproved = $purchase->getDateApproved();
                    if(isset($dateApproved)){
                        continue; // Skip approved
                    }

                    $projectPurchases[] = ['id' => $purchase->getId(),
                        'amount' => $purchase->getAmount(),
                        'totalPurchaseAmount' => $purchase->getTotalAmount(),
                        'date' => $purchase->getDateOfPurchase(),
                        'imageUrl' => $helper->asset($purchase, 'imageFile'),
//                'imageUrl' => $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath() . $helper->asset($purchase, 'imageFile'),
                        'data' => $purchase];
                }
            }
        }

        $json = $this->get('pp_util.handler')->serialize(['purchases' => $projectPurchases, 'status' => 'success']);

        return new JsonResponse($json, 200, [], true);
    }
    
    /**
     * @Route("/mobile/cost/{id}", name="mobileCostList")
     * @Method("GET")
     */
    public function costListAction($id, Request $request) {
        $project = $this->getDoctrine()
                ->getRepository('AppBundle:Project')
                ->find($id);

        $costs = $this->getDoctrine()
                ->getRepository('AppBundle:Cost')
                ->findBy(['project' => $project]);
        
        $results = array();
        foreach($costs as $cost){
            if(!$cost->getEnabled()){
                continue; // skip disabled
            }
            $results[] = ['id' => $cost->getId(), 'code_number' => $cost->getCodeNumber(), 'expense_type' => $cost->getExpenseType(), 'description' => $cost->getDescription()];
        }


        $json = $this->get('pp_util.handler')->serialize(['costs' => $results, 'status' => 'success']);

        return new JsonResponse($json, 200, [], true);
    }
    

    /**
     * @Route("/mobile/adduser", name="mobileAddUser")
     * @Method("POST")
     */
    public function signUpAction(Request $request) {
        $data = $request->getContent();
        $params = json_decode($data, true);

        $firstName = $params['firstname'];
        $lastName = $params['lastname'];
        $email = $params['email'];
        $password = $params['password'];
        $accountantEmail = $params['accountantEmail'];

        $userManager = $this->get('fos_user.user_manager');

        $user = $userManager->createUser();
        $user->setEmail($email)
                ->setPlainPassword($password)
                ->setEnabled(true)
                ->setFirstName($firstName)
                ->setLastName($lastName);


        if ($accountantEmail) {
            $user->setAccountantEmail($accountantEmail);
        }

        $userManager->updateUser($user);

        // send welcome mail
//        $message = (new \Swift_Message('Welcome to ProjectPro!'))
//                ->setFrom('no-reply@projectprohub.com')
//                ->setTo($email)
//                ->setBody($this->renderView(
//                        'email/welcome_email.html.twig', array('user' => $user)), 'text/html');
//
//        $this->get('mailer')->send($message);

        return new JsonResponse(['status' => 'success']);
    }
    
    /**
     * @Route("/mobile/projects", name="mobileAllProjectList")
     * @Method("GET")
     */
    public function projectListAction(Request $request)
    {
        $projects = $this->getDoctrine()
            ->getRepository('AppBundle:Project')
            ->findAll();
        
//        $hasBudget = array();
//        $hasNoBudget = array();
//        foreach($projects as $p){
//            if(count($p->getCosts()) > 0){
//                $hasBudget[] = $p;
//            } else {
//                $hasNoBudget[] = $p;
//            }
//        }
        
        $json = $this->get('pp_util.handler')->serialize(['projects' => $projects, 'status' => 'success']);

        return new JsonResponse($json, 200, [], true);
    }

}
