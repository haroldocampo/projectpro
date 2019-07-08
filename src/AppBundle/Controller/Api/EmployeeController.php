<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Employee;
use AppBundle\Entity\PaymentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGenerator;

class EmployeeController extends Controller {

    /**
     * @Route("/api/company/{id}/employees", name="apiEmployeeNew")
     * @Method("POST")
     */
    public function newAction($id, Request $request) {
        $params = $this->getRequest();
        $company = $this->get('pp_util.handler')->getCompany($id);
        $firstName = $params['firstName'];
        $lastName = $params['lastName'];
        $email = $params['email'];
        $roles = $params['roles'];
        $paymentTypes = $params['paymentTypes'];


        $existingUser = $this->getDoctrine()
                ->getRepository('AppBundle:User')
                ->findOneBy(['email' => $email]);

        if (!$existingUser) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return new JsonResponse([
                    'success' => false,
                    'errorMessage' => "Invalid email format"
                ]);
            }

            $userManager = $this->get('fos_user.user_manager');

            $user = $userManager->createUser();
            $user->setEmail($email)
                    //->setPlainPassword(uniqid())
                    ->setPlainPassword('secretpassword') // TODO: change temp password
                    ->setEnabled(true)
                    ->setPasswordSetToken($this->generateRandomString())
                    ->setFirstName($firstName)
                    ->setLastName($lastName);

            $userManager->updateUser($user);
        } else {
            $user = $existingUser;
        }

        $admin = $this->getUser(); // TODO: get admin id from request

        $existingEmployee = $this->getDoctrine()
                ->getRepository('AppBundle:Employee')
                ->findOneBy(['user' => $user, 'company' => $company]);

        if (!$existingEmployee) {
            $this->get('pp_employee.handler')->createEmployee($user, $company, $admin, $roles);

            $employee = $this->getDoctrine()
                    ->getRepository('AppBundle:Employee')
                    ->findBy(['user' => $user, 'company' => $company]);
            $employeeId = $employee[0]->getId();
        } else {
            $employee = $existingEmployee;
            $employee->setEnabled(true);
            
            $user->setFirstName($firstName)
                    ->setLastName($lastName);
            
            $this->get('pp_employee.handler')->setRoles($employee, $roles);
            $employeeId = $employee->getId();
        }



        $em = $this->getDoctrine()->getManager();

        $employee = $this->getDoctrine()
                    ->getRepository('AppBundle:Employee')
                    ->find($employeeId);

        // Clear Employee Payment Types
        $existingEmployeePaymentTypes = $this->getDoctrine()
                ->getRepository('AppBundle:EmployeePaymentType')
                ->findBy(['employee' => $employee]);

        foreach ($existingEmployeePaymentTypes as $eept) {
            $em->remove($eept);
        }

        foreach ($paymentTypes as $pt) {
            $paymentTypes = $this->getDoctrine()
                    ->getRepository('AppBundle:PaymentType')
                    ->findBy(['company' => $company, 'name' => $pt]);

            if (count($paymentTypes) > 0) {
                $paymentType = $paymentTypes[0];
            } else {
                // $paymentType = new PaymentType();
                // $paymentType->setCompany($company)
                //         ->setName($pt);
                // $em->persist($paymentType);

                // $em->flush();
                $paymentType = $this->getDoctrine()
                    ->getRepository('AppBundle:PaymentType')
                    ->create($company,$pt);
            }

            $employeePaymentType = new \AppBundle\Entity\EmployeePaymentType();
            

            $employeePaymentType->setEmployee($employee)
                    ->setPaymentType($paymentType)
                    ->setEnabled(true);

            $em->persist($employeePaymentType);
        }

        $em->flush();

        if ($existingEmployee) {
            return new JsonResponse([
                'message' => 'User/Employee Already Exists. User Information Updated.',
                'success' => true
                    ], 201);
        }

        return new JsonResponse([
            'message' => 'Employee has been added!',
            'success' => true
                ], 201);
    }

    /**
     * @Route("/api/employees/{id}/setDone", name="apiEmployeeSetDone")
     * @Method("POST")
     */
    public function setDoneAction($id, Request $request) {
        $params = $this->getRequest();
        $companyId = $params['companyId'];
        $companyId = $request->request->get('companyId');

        $em = $this->getDoctrine()->getManager();

        $user = $this->getDoctrine()
                ->getRepository('AppBundle:User')
                ->find($id);

        $company = $this->getDoctrine()
                ->getRepository('AppBundle:Company')
                ->find($companyId);

        $employee = $this->getDoctrine()
                        ->getRepository('AppBundle:Employee')
                        ->findBy(['user' => $user, 'company' => $company])[0];

        $employee->setIsDoneWizard(true);

        $em->flush();

        return new Response('Updated user');
    }

    /**
     * @Route("/api/employees/{id}/importedqb", name="apiEmployeeSetImportedToQb")
     * @Method("POST")
     */
    public function setImportedToQbAction($id, Request $request) {
        $params = $this->getRequest();

        $em = $this->getDoctrine()->getManager();

        $employee = $this->getDoctrine()
                ->getRepository('AppBundle:Employee')
                ->find($id);

        $employee->setIsImportedToQb(true);

        $em->flush();

        return new Response('Updated user');
    }

    /**
     * @Route("/api/employees/notifyqb", name="apiEmployeeNotifyQb")
     * @Method("POST")
     */
    public function notifyQbAction(Request $request) {
        $params = $this->getRequest();

        $em = $this->getDoctrine()->getManager();

        $employees = $this->getDoctrine()
                ->getRepository('AppBundle:Employee')
                ->findBy(['isImportedToQb' => true]);
                

        foreach($employees as $employee){
            $message = (new \Swift_Message("Import to QB Failed!"))
                    ->setFrom("fieldpurchases@projectprohub.com")
                    ->setTo($employee->getUser()->getEmail())
                    ->setBody('WARNING: ProjectPro could not find your instance of Quickbooks. Please be sure Quickbooks is open and your Quickbooks Web Connector is turned on. After correcting this, your import will complete automatically.');

            $this->get('mailer')->send($message);

            $employee->setIsImportedToQb(false);
        }

        $em->flush();

        return new Response('Updated user');
    }



    /**
     * @Route("/api/employees/{id}", name="apiEmployeeUpdate")
     * @Method({"PUT", "PATCH"})
     */
    public function updateAction($id, Request $request) {
        $data = $request->getContent();
        $params = json_decode($data, true);
        $roles = $params['roles'];
        $firstName = $params['first_name'];
        $lastName = $params['last_name'];
        $em = $this->getDoctrine()->getManager();                    

        $employee = $this->getDoctrine()
                ->getRepository('AppBundle:Employee')
                ->edit($id,$firstName,$lastName);                

        $this->get('pp_employee.handler')->setRoles($employee, $roles);

        $em->flush();

        return new JsonResponse(['success' => true]);
    }

    /**
     * @Route("/api/employees/{id}", name="apiEmployeeDelete")
     * @Method("DELETE")
     */
    public function deleteAction($id, Request $request) {    
        $employee = $this->getDoctrine()
                ->getRepository('AppBundle:Employee')
                ->delete($id);
        return new Response('Disabled user ' . $id, 204);
    }

    /**
     * @Route("/api/company/{id}/employees", name="apiEmployeeList")
     * @Method("GET")
     */
    public function listAction($id) {
        $company = $this->get('pp_util.handler')->getCompany($id);

        $employees = $this->getDoctrine()
                ->getRepository('AppBundle:Employee')
                ->findBy(['company' => $company]);

        foreach ($employees as $key => $employee) {
            if (!$employee->getEnabled()) {
                unset($employees[$key]);
            }
        }

        $json = $this->get('pp_util.handler')->serialize($employees);

        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @Route("/api/employees/{employeeId}/toggleRole", name="apiEmployeeAddRole")
     * @Method("POST")
     */
    public function toggleRoleAction($employeeId, Request $request) {
        $em = $this->getDoctrine()->getManager();

        $employee = $this->getDoctrine()
                ->getRepository('AppBundle:Employee')
                ->find($employeeId);

        if (!$employee) {
            $this->createNotFoundException(
                    sprintf(
                            'No user found with id %s', $employeeId
                    )
            );
        }

        $role = $request->request->get('role');

        if ($role == 'approver') {
            if ($employee->hasRole(Employee::$ROLE_APPROVER)) {
                $employee->removeRole(Employee::$ROLE_APPROVER);
            } else {
                $employee->addRole(Employee::$ROLE_APPROVER);
            }
        } elseif ($role == 'accountant') {
            if ($employee->hasRole(Employee::$ROLE_ACCOUNTANT)) {
                $employee->removeRole(Employee::$ROLE_ACCOUNTANT);
            } else {
                $employee->addRole(Employee::$ROLE_ACCOUNTANT);
            }
        } elseif ($role == 'purchaser') {
            if ($employee->hasRole(Employee::$ROLE_PURCHASER)) {
                $employee->removeRole(Employee::$ROLE_PURCHASER);
            } else {
                $employee->addRole(Employee::$ROLE_PURCHASER);
            }
        }

        $em->flush();

        $json = $this->get('pp_util.handler')->serialize($employee);

        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @Route("/api/company/{id}/approvers/", name="apiCompanyApproversList")
     * @Method("GET")
     */
    public function getCompanyApproversAction($id) {
        $company = $this->get('pp_util.handler')->getCompany($id);

        $employees = $this->getDoctrine()
                ->getRepository('AppBundle:Employee')
                ->findBy(['company' => $company, 'enabled' => true]);

        $approvers = [];

        foreach ($employees as $employee) {
            if ($employee->hasRole(Employee::$ROLE_APPROVER)) {
                array_push($approvers, $employee);
            }
        }

        $json = $this->get('pp_util.handler')->serialize($approvers);

        return new JsonResponse($json, 200, [], true);
    }
    
    /**
     * @Route("/api/company/{id}/approversfilter/", name="apiCompanyApproversFilterList")
     * @Method("GET")
     */
    public function getCompanyApproversFilterAction($id) {
        $company = $this->get('pp_util.handler')->getCompany($id);

        $employees = $this->getDoctrine()
                ->getRepository('AppBundle:Employee')
                ->findBy(['company' => $company]);

        $approvers = [];

        foreach ($employees as $employee) {
            if ($employee->hasRole(Employee::$ROLE_APPROVER)) {
                
                $purchases = $this->getDoctrine()
                    ->getRepository('AppBundle:Purchase')
                    ->findAllUnapprovedByEmployee($employee->getId());
                
                $unapprovedCount = count($purchases);
                
                array_push($approvers, ['employee' => $employee, 'unapprovedCount' => $unapprovedCount]);
            }
        }

        $json = $this->get('pp_util.handler')->serialize($approvers);

        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @param int $length
     * @return bool|string
     */
    private function generateRandomString($length = 24) {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
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
