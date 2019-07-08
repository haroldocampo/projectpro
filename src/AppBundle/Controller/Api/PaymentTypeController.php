<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\PaymentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PaymentTypeController extends Controller {

    /**
     * @Route("/api/company/{id}/paymentTypes", name="apiPaymentTypeNew")
     * @Method("POST")
     */
    public function newAction($id, Request $request) { 
        $company = $this->get('pp_util.handler')->getCompany($id);
        $params = $this->getRequest();
        $name = $params['name'];

        if (!$name) {
            throw $this->createNotFoundException("Missing name from request");
        }

        $paymentType = $this->getDoctrine()
            ->getRepository('AppBundle:PaymentType')
            ->create($company,$name);

        return new JsonResponse("Added payment type");
    }

    /**
     * @Route("/api/company/{id}/employee/paymentTypes/add", name="apiEmployeePaymentTypeNew")
     * @Method("POST")
     */
    public function newEmployeePaymentTypeAction($id, Request $request) {
        $company = $this->get('pp_util.handler')->getCompany($id);
        $params = $this->getRequest();
        $name = $params['name'];
        $employeeId = $params['employeeId'];
        $paymentType = null;
        if (!$name) {
            throw $this->createNotFoundException("Missing name from request");
        }

        $employeePaymentType = $this->getDoctrine()
            ->getRepository('AppBundle:EmployeePaymentType')
            ->create($company,$employeeId,$name);

        return new JsonResponse("Added payment type");
    }

    /**
     * @Route("/api/company/{id}/employee/paymentTypes/remove", name="apiEmployeePaymentTypeRemove")
     * @Method("POST")
     */
    public function removeEmployeePaymentTypeAction($id, Request $request) {
        $company = $this->get('pp_util.handler')->getCompany($id);
        $params = $this->getRequest();
        $name = $params['name'];
        $employeeId = $params['employeeId'];
        //$itemId = $params['itemId'];

        $deleted = $this->getDoctrine()
                ->getRepository('AppBundle:EmployeePaymentType')
                ->delete($company,$employeeId,$name);
        
        if (is_null($deleted)) {
            throw $this->createNotFoundException(
                    sprintf(
                            'No payment type found'
                    )
            );
        }        
        return new JsonResponse("Removed payment types");
    }

    /**
     * @Route("/api/paymentTypes/{id}", name="apiPaymentTypeDelete")
     * @Method("DELETE")
     */
    public function deleteAction($id) {
        $deleted = $this->getDoctrine()
                ->getRepository('AppBundle:PaymentType')
                ->delete($id);
        if (is_null($deleted)) {
            throw $this->createNotFoundException(
                    sprintf(
                            'No payment type found with id %s', $id
                    )
            );
        }        
        return new Response('Deleted Payment Type ' . $id, 204);
    }

    /**
     * @Route("/api/company/{id}/paymentTypes", name="apiPaymentTypeCompanyList")
     * @Method("GET")
     */
    public function companyListAction($id) {
        $company = $this->get('pp_util.handler')->getCompany($id);

        $paymentTypes = $this->getDoctrine()
                ->getRepository('AppBundle:PaymentType')
                ->findBy(['company' => $company, 'enabled' => true]);

        $json = $this->get('pp_util.handler')->serialize($paymentTypes);

        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @Route("/api/company/{id}/paymentTypesList", name="apiPaymentTypesCompanyList")
     * @Method("GET")
     */
    public function companyPaymentTypeListAction($id) {
        $company = $this->get('pp_util.handler')->getCompany($id);

        $paymentTypes = $this->getDoctrine()
                ->getRepository('AppBundle:PaymentType')
                ->findBy(['company' => $company, 'enabled' => true]);

        $json = $this->get('pp_util.handler')->serialize($paymentTypes);

        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @Route("/api/company/{id}/transactionTypes", name="apiTransactionTypesCompanyList")
     * @Method("GET")
     */
    public function companyTransactionTypesAction($id) {
        $company = $this->get('pp_util.handler')->getCompany($id);

        $transactionTypes = $this->getDoctrine()
                ->getRepository('AppBundle:TransactionType')
                ->findAll();

        $json = $this->get('pp_util.handler')->serialize($transactionTypes);

        return new JsonResponse($json, 200, [], true);
    }

    
    /**
     * @Route("/api/paymentTypes/{id}/associatetransactiontype", name="apiPaymentTypeAssociateTransactionType")
     * @Method("PUT")
     */
    public function associateTransactionTypeAction($id) {
        $params = $this->getRequest();
        $transactionTypeId = $params['transactionTypeId'];

        $paymentType = $this->getDoctrine()
                ->getRepository('AppBundle:PaymentType')
                ->associateTransactionType($id, $transactionTypeId);
                
        if (is_null($paymentType)) {
            throw $this->createNotFoundException(
                    sprintf(
                            'No payment type found with id %s', $id
                    )
            );
        }        
        return new Response('Update Payment Type with Transaction ID' . $transactionTypeId, 204);
    }

    /**
     * @Route("/api/company/{id}/paymentTypesListWeb", name="apiPaymentTypesCompanyListWeb")
     * @Method("GET")
     */
    public function companyPaymentTypesListWebAction($id) {
        $company = $this->get('pp_util.handler')->getCompany($id);

        $paymentTypes = $this->getDoctrine()
                ->getRepository('AppBundle:PaymentType')
                ->findBy(['company' => $company, 'enabled' => true]);

        $result = [];

        foreach ($paymentTypes as $pt) {
            $result[] = ['cannotDelete' => $pt->getHasPurchases(), 'item' => $pt];
        }

        $json = $this->get('pp_util.handler')->serialize($result);

        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @Route("/api/company/{id}/allPaymentTypesList", name="apiAllPaymentTypesCompanyList")
     * @Method("GET")
     */
    public function companyAllPaymentTypeListAction($id) {
        $result = [];
        $company = $this->get('pp_util.handler')->getCompany($id);

        $paymentTypes = $this->getDoctrine()
                ->getRepository('AppBundle:PaymentType')
                ->findBy(['company' => $company, 'enabled' => true]);
        
        foreach ($paymentTypes as $pt) {
            if($pt->getHasPurchases()){
                 $result[] = $pt;
            }
        }

        $json = $this->get('pp_util.handler')->serialize($result);

        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @Route("/api/paymentTypes", name="apiPaymentTypeEmployeeList")
     * @Method("GET")
     */
    public function employeeListAction(Request $request) {
        $companyId = $request->query->get('companyId');
        $employeeId = $request->query->get('employeeId');
        $isSuperAdmin = $request->query->get('isSuperAdmin');

        if ($isSuperAdmin && strtolower($isSuperAdmin) === 'true') {
            $company = $this->getDoctrine()
                    ->getRepository('AppBundle:Company')
                    ->find($companyId);

            if (!$company) {
                throw $this->createNotFoundException(
                        sprintf(
                                'No company found with id %s', $employeeId
                        )
                );
            }

            $paymentTypes = $this->getDoctrine()
                    ->getRepository('AppBundle:PaymentType')
                    ->findBy(['company' => $company, 'enabled' => true]);
        } else {
            $employee = $this->getDoctrine()
                    ->getRepository('AppBundle:Employee')
                    ->find($employeeId);

            if (!$employee) {
                throw $this->createNotFoundException(
                        sprintf(
                                'No employee found with id %s', $employeeId
                        )
                );
            }
            $ePaymentTypes = $this->getDoctrine()
                    ->getRepository('AppBundle:EmployeePaymentType')
                    ->findBy(['employee' => $employee, 'enabled' => true]);

            $paymentTypes = [];
            foreach ($ePaymentTypes as $ePaymentType) {
                $paymentTypes[] = $ePaymentType->getPaymentType();
            }
        }

        $json = $this->get('pp_util.handler')->serialize($paymentTypes);

        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @Route("/api/company/{id}/user/{employeeid}/paymentTypes", name="apiPaymentTypeCompanyList")
     * @Method("GET")
     */
    public function userListAction($id, $employeeid) {
        $company = $this->get('pp_util.handler')->getCompany($id);

        $employee = $this->getDoctrine()
                ->getRepository('AppBundle:Employee')
                ->find($employeeid);

        $paymentTypes = $this->getDoctrine()
                ->getRepository('AppBundle:PaymentType')
                ->findBy(['company' => $company, 'enabled' => true]);
        $result = [];

        foreach ($paymentTypes as $paymentType) {
            //$paymentType = new PaymentType();
            foreach ($paymentType->getEmployeePaymentTypes() as $ept) {
                //$ept = new \AppBundle\Entity\EmployeePaymentType();
                if ($ept->getEmployee()->getId() == $employeeid) {
                    $result[] = $paymentType;
                    break;
                }
            }
        }

        $json = $this->get('pp_util.handler')->serialize($result);

        return new JsonResponse($json, 200, [], true);
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
