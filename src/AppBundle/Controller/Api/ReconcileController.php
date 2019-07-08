<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Purchase;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use \Doctrine\Common\Collections\Criteria;

class ReconcileController extends Controller {

    /**
     * @Route("/api/company/{id}/reconcile", name="apiReconcile")
     * @Method("POST")
     */
    public function reconcileAction($id, Request $request) {
        $data = $request->getContent();
        $params = json_decode($data, true);

        $company = $this->get('pp_util.handler')->getCompany($id);

        $paymentTypes = $params['paymentTypes']; // array of payment type id
        $statusArray = $params['statuses']; // array : 'approved' 'not_approved'

        $fPaymentTypes = [];
        foreach ($paymentTypes as $paymentTypeId) {
            $paymentType = $this->getDoctrine()
                    ->getRepository('AppBundle:PaymentType')
                    ->find($paymentTypeId);

            if ($paymentType) {
                $fPaymentTypes[] = $paymentType;
            }
            
        }
        // filter approved
        $fStatus = [];
        foreach ($statusArray as $status) {
            switch ($status) {
                case 'approved':
                    $fStatus[] = Purchase::$STATUS_APPROVED;
                    break;
                case 'not_approved':
                    $fStatus[] = Purchase::$STATUS_NOT_APPROVED;
                    break;
            }
        }

        $em = $this->getDoctrine()->getManager();

        $projects = $this->getDoctrine()
                ->getRepository('AppBundle:Project')
                ->findAllActiveByCompany($company);

        $reconciled = [];
        foreach ($projects as $project) {
            $purchases = $this->getDoctrine()
                    ->getRepository('AppBundle:Purchase')
                    ->findBy(['status' => $fStatus, 'paymentType' => $fPaymentTypes, 'project' => $project]);

            foreach ($purchases as $purchase) {
                if (!$purchase->getMatchedImportedTransaction()) {
                    $totalAmount = $purchase->getTotalAmount();
                    $totalAmount = abs($totalAmount);

                    // OLD:
                    //$matchedImportedTransactions = $this->getDoctrine()
                    //        ->getRepository('AppBundle:ImportedTransaction')
                    //        ->findBy(['amount' => $totalAmount, 'matchedPurchase' => null, 'company' => $company, 'date' => $purchase->getDateOfPurchase()]);
                    
                    // CHANGED: 1-26-2018, PURCHASE DATES will no longer be used for MATCHING, only AMOUNTS
                    // $matchedImportedTransactions = $this->getDoctrine()
                    //         ->getRepository('AppBundle:ImportedTransaction')
                    //         ->findBy(['amount' => $totalAmount, 'matchedPurchase' => null, 'company' => $company]);

                    // CHANGED: 6-26-2018, Created Custom Repo To Handle Absolute Values
                    $matchedImportedTransactions = $this->getDoctrine()
                            ->getRepository('AppBundle:ImportedTransaction')
                            ->getMatchedTransactions($company,$totalAmount);

                    // check if only 1 match
                    if (count($matchedImportedTransactions) == 1) {
                        $matchedIT = $matchedImportedTransactions[0];

                        $matchedIT->setMatchedPurchase($purchase);
                        $purchase->setMatchedImportedTransaction($matchedIT);

                        $em->flush();

                        $reconciled[] = [
                            'purchase' => $purchase,
                            'importedTransaction' => $matchedIT
                        ];
                    }
                }
            }
        }

        // get all unreconciled
        $urImportedTransactions = $this->getDoctrine()
                ->getRepository('AppBundle:ImportedTransaction')
                ->findBy(['matchedPurchase' => null, 'company' => $company]);
        $urPurchases = $this->getDoctrine()
                ->getRepository('AppBundle:Purchase')
                ->findBy(['matchedImportedTransaction' => null, 'status' => $fStatus, 'paymentType' => $fPaymentTypes]);

        foreach ($urPurchases as $key => $purchase) {
            if ($purchase->getProject()->getCompany() != $company) {
                unset($urPurchases[$key]);
            }
        }

        $json = $this->get('pp_util.handler')->serialize([
            'reconciled' => $reconciled,
            'unreconciled' => [
                'importedTransactions' => $urImportedTransactions,
                'purchases' => $urPurchases
            ]
        ]);

        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @Route("/api/reconcile/deleteItems", name="apiReconcileDeleteItems")
     * @Method("POST")
     */
    public function deleteItemsAction(Request $request) {
        $data = $request->getContent();
        $params = json_decode($data, true);

        $purchaseIds = $params['purchaseIds'];
        $importedTransactionIds = $params['importedTransactionIds'];

        $em = $this->getDoctrine()->getManager();

        foreach ($purchaseIds as $id) {
            $purchase = $this->getPurchase($id);
            $em->remove($purchase);
        }

        foreach ($importedTransactionIds as $id) {
            $importedTransaction = $this->getImportedTransaction($id);
            $em->remove($importedTransaction);
        }

        $em->flush();

        return new JsonResponse('Deleted selected items');
    }

    /**
     * @Route("/api/reconcile/manual", name="apiManualReconcile")
     * @Method("POST")
     */
    public function matchAction(Request $request) {
        $params = $this->getRequest();

        $purchaseId = $params['purchaseId'];
        $importedTransactionId = $params['importedTransactionId'];
        $action = $params['action']; // match or unmatch

        $em = $this->getDoctrine()->getManager();

        $purchase = $this->getPurchase($purchaseId);
        $importedTransaction = $this->getImportedTransaction($importedTransactionId);

        if ($action === 'match') {
            $purchase->setMatchedImportedTransaction($importedTransaction);
            $importedTransaction->setMatchedPurchase($purchase);
        } elseif ($action === 'unmatch') {
            $purchase->setMatchedImportedTransaction(null);
            $importedTransaction->setMatchedPurchase(null);
        } else {
            throw $this->createNotFoundException('Action not found');
        }

        $em->flush();

        return new JsonResponse(ucfirst($action) . " successful");
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
                    sprintf(
                            'No purchase found with %s', $id
                    )
            );
        }

        return $purchase;
    }

    /**
     * @param $id
     * @return \AppBundle\Entity\ImportedTransaction|null|object
     */
    private function getImportedTransaction($id) {
        $importedTransaction = $this->getDoctrine()
                ->getRepository('AppBundle:ImportedTransaction')
                ->find($id);

        if (!$importedTransaction) {
            throw $this->createNotFoundException(
                    sprintf(
                            'No imported transaction found with %s', $id
                    )
            );
        }

        return $importedTransaction;
    }

    private function filterPurchaseStatus($purchase, $fStatus) {

        foreach ($fStatus as $status) {
            if ($purchase->getStatus() != $status) {
                return false;
            }
        }

        return true;
    }
    
    private function filterPaymentTypes($purchase, $fPaymentTypes) {
        
        foreach ($fPaymentTypes as $pt) {
            if ($purchase->getPaymentType()->getId() != $pt->getId()) {
                return false;
            }
        }

        return true;
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
