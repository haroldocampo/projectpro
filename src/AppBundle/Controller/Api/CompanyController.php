<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Company;
use AppBundle\Entity\Employee;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use SimpleXMLElement;
class CompanyController extends Controller {

    const curlChargifyAPIKey = 'DaacmafsgJFjFumNW0kbCeZzDqxG8zJT3TWqAmSLm8:x';
    const chargifySiteURL = 'https://projectpro.chargify.com';
    
    /**
     * @Route("/api/companies", name="apiCompanyAdd")
     * @Method("POST")
     */
    public function newAction(Request $request) {
        $params = $this->getRequest();
        $user = $this->getUser();

        //$accountantEmail = $params['accountantEmail'];
        $name = $params['name'];

        // Change this
        $accountantEmail = $user->getEmail();        

        
        $em = $this->getDoctrine()->getManager();

        // $company = new Company();
        // $company->setName($name);
        // $em->persist($company);
        $company = $this->getDoctrine()
            ->getRepository('AppBundle:Company')
            ->create($name);

        // create admin employee
        $employee = $this->getDoctrine()
            ->getRepository('AppBundle:Employee')
            ->create($user, $company, ['accountant', 'approver', 'admin']);
//        $employee = new Employee();
//        $employee->setCompany($company)
//                ->setUser($user)
//                ->addRole(Employee::$ROLE_ADMIN)
//                ->addRole(Employee::$ROLE_ACCOUNTANT)
//                ->addRole(Employee::$ROLE_APPROVER)
//                ->addRole(Employee::$ROLE_PURCHASER);
//
//        $em->persist($employee);

        $user->setIsDoneWizard(false);

        $em->flush();

        if ($accountantEmail == $user->getEmail()) {
            $employee->setIsDefaultAccountant(true);
            $em->flush();
        } else {
            // create seperate user for accountant
            $existingAccountant = $this->getDoctrine()
                ->getRepository('AppBundle:User')
                ->findOneBy(['email' => $accountantEmail]);

            if (!$existingAccountant) {
                $userManager = $this->get('fos_user.user_manager');                
                $accountantUser = $userManager->createUser();
                $accountantUser->setEmail($accountantEmail)
                    ->setPlainPassword('secretpassword')
                    ->setEnabled(true)
                    ->setPasswordSetToken($this->generateRandomString())
                    ->setFirstName('')
                    ->setLastName('');

                $userManager->updateUser($accountantUser);
            } else {
                $accountantUser = $existingAccountant;
            }

            // create employee record
            $this->get('pp_employee.handler')->createEmployee($accountantUser, $company, $user, ['accountant'], true);
        }

        return new JsonResponse($company->getId());
    }

    /**
     * @Route("/api/companies", name="apiCompanyList")
     * @Method("GET")
     */
    public function listAction(Request $request) {
        $employeeId = $request->query->get('employeeId');

        $employee = $this->getDoctrine()
                ->getRepository('AppBundle:Employee')
                ->find($employeeId);

        if (!$employee) {
            return new Response("Employee not found", 500);
        }

        $user = $employee->getUser();

//        if ($this->get('security.authorization_checker')->isGranted(User::ROLE_ADMIN)) {
//            $employments = $this->getDoctrine()
//                ->getRepository('AppBundle:Company')
//                ->findAll();
//        } else {
//            $employments = $user->getEmployments();
//        }

        $companies = $this->getDoctrine()->getRepository('AppBundle:Company')
        ->listByUser($user);        

        return new JsonResponse($companies);
    }
    
    /**
     * @Route("/api/company/{id}/account", name="apiAccount")
     * @Method("GET")
     */
    public function accountAction($id, Request $request) {
        $companyId = $id;

        $company = $this->getDoctrine()
                ->getRepository('AppBundle:Company')
                ->find($companyId);

        if (!$company) {
            return new Response("Company not found", 500);
        }

        $billing = $this->getBillingForCompany($company);    
        
        $result = ['companyName' => $company->getName(), 'billing' => $billing, 'isQbIntegrated' => $company->isQbIntegrated()];

        return new JsonResponse($result);
    }
    /**
     * @Route("/api/company/{id}/qbIntegration", name="apiCompanyQbIntegration")
     * @Method("POST")
     */
    public function QbIntegrationAction($id, Request $request){
        $params = $this->getRequest();        
        $isQbIntegrated = $params['isQbIntegrated'];
        $em = $this->getDoctrine()->getManager();

        $company = $this->getDoctrine()
                ->getRepository('AppBundle:Company')
                ->find($id);                
        if (!$company) {
            return new Response("Company not found", 500);
        }
        $company->setQbIntegrated($isQbIntegrated);
        $this->insertQbUser($em, $id);
        $em->flush();
            $result = ['isQbIntegrated' => $company->isQbIntegrated()];
        return new JsonResponse($result);
                                    
    }

    private function insertQbUser($em, $companyId){
        $sql = " 
            SELECT *
            FROM quickbooks_user
            where qb_username = 'projectpro_$companyId'
        ";

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        $raw = json_encode($stmt->fetchAll());
        $results = json_decode($raw, true);

        if(count($results) > 0){
            return; // Do not add duplicate user
        }

        $sql = " 
            INSERT INTO
            quickbooks_user
            values ('projectpro_$companyId', '6ad80d33dcc890358f2712784341076a157f0afe', '', 0, 0, 'e', '2019-1-1 23:00:00', '2019-1-1 23:00:00')
        ";

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
    }
    /**
     * @Route("/api/company/{id}/qbConnector", name="apiExportQbConnector")
     * @Method("GET")
     */
    public function exportAction($id, Request $request) {         
        $company = $this->getDoctrine()
                ->getRepository('AppBundle:Company')
                ->find($id);
                 
        if (!$company) {
                return new Response("Company not found", 500);
        }       
        $xml = $this->createQbConnectorXml($company->getId());
        return $this->exportXml($xml->asXML());                     
    }
    
    /**
     * @Route("/api/company/{id}/name", name="apiCompanyName")
     * @Method("PUT")
     */
    public function companyNameAction($id, Request $request) {
        $companyId = $id;
        $params = $this->getRequest();
        $name = $params['name'];        

        $company = $this->getDoctrine()
                ->getRepository('AppBundle:Company')
                ->find($companyId);

        
        $company = $this->getDoctrine()
            ->getRepository('AppBundle:Company')
            ->edit($companyId,$name);            
        if (!$company) {
                return new Response("Company not found", 500);
        }
        
        $subscription = $this->getBillingForCompany($company);
        $customerId = $subscription['subscription']['customer']['id'];
        
        // Update Customer
        $customerProfile = [
            'customer' => [
                'organization' => $params['name'],
            ]
        ];

        $customer_data_string = json_encode($customerProfile);

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_USERPWD, $this::curlChargifyAPIKey);
        curl_setopt($curl, CURLOPT_URL, 'https://projectpro.chargify.com/customers/' . $customerId . '.json');
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $customer_data_string);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return ['error' => "cURL Error #:" . $err, 'success' => false];
        }

        $customerUpdateJson = json_decode($response, true);
        // End of update customer
        
        return new JsonResponse(true);
    }
    
    
    /**
     * @param Company $company
     * @return mixed|Response
     */
    private function getBillingForCompany($company)
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_USERPWD, $this::curlChargifyAPIKey);
        curl_setopt($curl, CURLOPT_URL, 'https://projectpro.chargify.com/subscriptions/' . $company->getSubscriptionId() . '.json');
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return new Response("cURL Error #:" . $err, 500);
        }

        if (empty($response)) {
            return null;
        }

        // If using JSON...
        $json = json_decode($response, true);

        return $json;
    }

    private function getRequest() {
        $params = array();
        $content = $this->container->get('request_stack')->getCurrentRequest()->getContent();

        if (!empty($content)) {
            $params = json_decode($content, true); // 2nd param to get as array
        }

        return $params;
    }

    private function createQbConnectorXml($companyId){
        $xml = new SimpleXMLElement('<QBWCXML/>');
        $xml->addChild('AppID', $companyId);
        $xml->addChild('AppName','ProjectPro QB Integrator');
        //$xml->addChild('AppURL','https://projectpro-staging.herokuapp.com/qb/project-pro/web_connector.php'); // staging
        $xml->addChild('AppURL','https://member.projectprohub.com/qb/project-pro/web_connector.php'); // live
        $xml->addChild('AppDescription');
        //$xml->addChild('AppSupport','https://projectpro-staging.herokuapp.com'); // staging
        $xml->addChild('AppSupport','https://member.projectprohub.com'); // live
        $xml->addChild('UserName','projectpro_'.$companyId);
        $xml->addChild('OwnerID','{'.$this->guidv4().'}');
        $xml->addChild('FileID','{'.$this->guidv4().'}');
        $xml->addChild('QBType','QBFS');

        $scheduler = $xml->addChild('Scheduler');
        $scheduler->addChild('RunEveryNMinutes','1');

        $xml->addChild('IsReadOnly','false');

        return $xml;
    }
    private function exportXml($xml){
        $response = new Response($xml);        
        $dispositionHeader = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,'quickbooks_projectpro.qwc'
        );

        $response->headers->set('Content-Type', 'text/xml; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;        
    }
    private function guidv4(){
        if (function_exists('com_create_guid') === true)
            return trim(com_create_guid(), '{}');

        $data = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}

