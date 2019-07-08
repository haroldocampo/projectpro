<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Company;
use AppBundle\Entity\Employee;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BillingController extends Controller {

    const curlChargifyAPIKey = 'DaacmafsgJFjFumNW0kbCeZzDqxG8zJT3TWqAmSLm8:x';
    const chargifySiteURL = 'https://projectpro.chargify.com';

    public function indexAction($name) {
        return $this->render('', array('name' => $name));
    }

    /**
     * @Route("/api/billing/square/process", name="apiBillingSquareProcess")
     * @Method("POST")
     */
    public function processPaymentAction(Request $request) {
        $nonce = $request->request->get('nonce');
        $billingAddress = $request->request->get('billingAddress');
        $billingCity = $request->request->get('billingCity');
        $billingState = $request->request->get('billingState');
        $billingCountry = $request->request->get('billingCountry');
        $billingEmail = $request->request->get('billingEmail');
        $companyId = $request->request->get('companyId');
        $billingZip = $request->request->get('billingZip');

        $company = $this->getDoctrine()
                ->getRepository('AppBundle:Company')
                ->find($companyId);

        if (!$company) {
            return new Response('Invalid company', 500);
        }

        $subscription = $this->getBillingForCompany($company);
        $subscriptionId = $subscription['subscription']['id'];
        $customerId = $subscription['subscription']['customer']['id'];

        $paymentProfile = [
            'payment_profile' => [
                'customer_id' => $customerId,
                'first_name' => $subscription['subscription']['customer']['first_name'],
                'last_name' => $subscription['subscription']['customer']['last_name'],
                'billing_address' => $billingAddress,
                'billing_city' => $billingCity,
                'billing_state' => $billingState,
                'billing_zip' => $billingZip,
                'billing_country' => $billingCountry,
                'billing_email' => $billingEmail,
                'payment_method_nonce' => $nonce
            ]
        ];

        $data_string = json_encode($paymentProfile);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_USERPWD, $this::curlChargifyAPIKey);
        curl_setopt($curl, CURLOPT_URL, 'https://projectpro.chargify.com/payment_profiles.json');
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        //var_dump('post/put payment profile \n' . $response);
        if ($err) {
            return new Response("cURL Error #:" . $err, 500);
        }

        $json = json_decode($response, true);

        //var_dump($json);

        if (array_key_exists('errors', $json)) {
            return $this->redirect($this->generateUrl('showCompanyAccountDashboard', ['id' => $companyId, 'error' => $json["errors"][0]]));
        }

        $paymentProfileId = $json['payment_profile']['id'];

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_USERPWD, $this::curlChargifyAPIKey);
        curl_setopt($curl, CURLOPT_URL, $this::chargifySiteURL . '/subscriptions/' . $company->getSubscriptionId() . '/payment_profiles/' . $paymentProfileId . '/change_payment_profile.json');
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $paymentTypeResponse = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        //var_dump('default payment type \n' . $paymentTypeResponse);
        if ($err) {
            return new Response("cURL Error #:" . $err, 500);
        }

        if (array_key_exists('errors', $json)) {
            return $this->redirect($this->generateUrl('showCompanyAccountDashboard', ['id' => $companyId, 'error' => $json["errors"][0]]));
        }

        // If using JSON...
        $paymentTypeJson = json_decode($paymentTypeResponse, true);

        // Update Customer
        $customerProfile = [
            'customer' => [
                'email' => $billingEmail,
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
            return new Response("cURL Error #:" . $err, 500);
        }

        $customerUpdateJson = json_decode($response, true);
        // End of update customer

        if ($subscription["subscription"]["state"] === 'past_due') {
            $curl = curl_init();

            curl_setopt($curl, CURLOPT_USERPWD, $this::curlChargifyAPIKey);
            curl_setopt($curl, CURLOPT_URL, 'https://projectpro.chargify.com/subscriptions/' . $subscriptionId . '/retry.json');
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
            //curl_setopt($curl, CURLOPT_POSTFIELDS, $customer_data_string);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);
            $json = json_decode($response, true);
            if (array_key_exists('errors', $json)) {
                var_dump($json);
                return $this->redirect($this->generateUrl('showCompanyAccountDashboard', ['id' => $companyId, 'error' => $json["errors"][0]]));
            }
        } else if ($subscription["subscription"]["state"] === 'canceled') {
            $reactivate = [
                'include_trial' => 1
            ];

            $reactivate_data_string = json_encode($reactivate);

            $curl = curl_init();

            curl_setopt($curl, CURLOPT_USERPWD, $this::curlChargifyAPIKey);
            curl_setopt($curl, CURLOPT_URL, 'https://projectpro.chargify.com/subscriptions/' . $subscriptionId . '/reactivate.json');
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($curl, CURLOPT_POSTFIELDS, $reactivate_data_string);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);
            $json = json_decode($response, true);
            if (array_key_exists('errors', $json)) {
                var_dump($json);
                return $this->redirect($this->generateUrl('showCompanyAccountDashboard', ['id' => $companyId, 'error' => $json["errors"][0]]));
            }
        } else {
            
        }
        // THIS AREA IS COMMENTED BECAUSE WE DONT WANT TO BILL immediately, uncomment if you want to bill immediately
//            // update billing to date now
//            $updatedSubscription = [
//                'subscription' => [
//                    'next_billing_at' => (new \DateTime())->format('n/j/Y H:i:s T'),
//                ]
//            ];
//
//            $customer_data_string = json_encode($updatedSubscription);
//
//            $curl = curl_init();
//
//            curl_setopt($curl, CURLOPT_USERPWD, $this::curlChargifyAPIKey);
//            curl_setopt($curl, CURLOPT_URL, 'https://projectpro.chargify.com/subscriptions/' . $subscriptionId . '.json');
//            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
//            curl_setopt($curl, CURLOPT_POSTFIELDS, $customer_data_string);
//            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
//
//            $response = curl_exec($curl);
//            $err = curl_error($curl);
//
//            curl_close($curl);
//
//            if ($err) {
//                return new Response("cURL Error #:" . $err, 500);
//            }
        //var_dump('update subscription \n' . $response);
        return $this->redirect($this->generateUrl('showCompanyAccountDashboard', ['id' => $companyId]));
    }

    /**
     * @Route("/api/billing/{id}/payment", name="apiBillingCheckNearing")
     */
    public function checkIfNearingBillingAction(Request $request) {
        
    }

    /**
     * This updates the payment details for the company - used when the trial is over
     * @Route("/api/billing/{id}/payment", name="apiBillingUpdatePayment")
     * @Method("POST")
     */
    public function updatePaymentAction($id, Request $request) {
        $params = $this->getRequest();
        $company = $this->getDoctrine()
                ->getRepository('AppBundle:Company')
                ->find($id);

        if (!$company) {
            return new Response('Invalid company', 500);
        }

        $fullNumber = $params['fullNumber'];
        $cvv = $params['ccv'];
        $expirationMonth = $params['expirationMonth'];
        $expirationYear = $params['expirationYear'];
        $billingAddress = $params['billingAddress'];
        $billingCity = $params['billingCity'];
        $billingState = $params['billingState'];
        $billingZip = $params['billingZip'];
        $billingCountry = $params['billingCountry'];
        $billingEmail = $params['billingEmail'];

        $subscription = $this->getBillingForCompany($company);
        $customerId = $subscription['subscription']['customer']['id'];

        $paymentProfile = [
            'payment_profile' => [
                'customer_id' => $customerId,
                'first_name' => $subscription['subscription']['customer']['first_name'],
                'last_name' => $subscription['subscription']['customer']['last_name'],
                'full_number' => $fullNumber,
                'expiration_month' => $expirationMonth,
                'expiration_year' => $expirationYear,
                'billing_address' => $billingAddress,
                'billing_city' => $billingCity,
                'billing_state' => $billingState,
                'billing_zip' => $billingZip,
                'billing_country' => $billingCountry,
                //'billing_email' => $billingEmail,
                'cvv' => $cvv
            ]
        ];

        $data_string = json_encode($paymentProfile);

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_USERPWD, $this::curlChargifyAPIKey);
        curl_setopt($curl, CURLOPT_URL, 'https://projectpro.chargify.com/payment_profiles.json');
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return new Response("cURL Error #:" . $err, 500);
        }

        if ($response["errors"]) {
            return new Response("cURL Error #:" . $response, 500);
        }

        $json = json_decode($response, true);

        $paymentProfileId = $json['payment_profile']['id'];

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_USERPWD, $this::curlChargifyAPIKey);
        curl_setopt($curl, CURLOPT_URL, $this::chargifySiteURL . '/subscriptions/' . $company->getSubscriptionId() . '/payment_profiles/' . $paymentProfileId . '/change_payment_profile.json');
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $paymentTypeResponse = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return new Response("cURL Error #:" . $err, 500);
        }

        // If using JSON...
        $paymentTypeJson = json_decode($paymentTypeResponse, true);

        // Update Customer
        $customerProfile = [
            'customer' => [
                'email' => $billingEmail,
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
            return new Response("cURL Error #:" . $err, 500);
        }

        $customerUpdateJson = json_decode($response, true);
        // End of update customer

        return new JsonResponse($paymentTypeJson);
    }

    /**
     * @Route("/api/billing/{id}/paymentpage", name="apiBillingPaymentPage")
     * @Method("GET")
     */
    public function getPaymentServicePageURL($id) {
        $company = $this->getDoctrine()
                ->getRepository('AppBundle:Company')
                ->find($id);

        if (!$company) {
            return new Response('Invalid company', 500);
        }

        // shared key: 1QDxMALlZ35X7BiwnAA3arofmIdSrIhkJgTLW9VVAE

        $message = 'update_payment--' . $company->getSubscriptionId() . '--1QDxMALlZ35X7BiwnAA3arofmIdSrIhkJgTLW9VVAE';
        $token = sha1($message);

        $url = $this::chargifySiteURL . '/update_payment/' . $company->getSubscriptionId() . '/' . $token;

        return new Response($url);
    }

    /**
     * @Route("/api/billing/create", name="apiBillingCreate")
     * @Method("POST")
     */
    public function createBillingAction(Request $request) {
        $devEmails = ['marksegalle@live.com', 'mark.segalle@artise.io', 'test@test.com', 'mark@test.com'];

        $user = $this->getUser();
        if (in_array($user->getEmail(), $devEmails)) {
            return new Response('Developer', 200);
        }

        //if ($this->getUser()->hasRole(User::ROLE_ADMIN)) {
        //    return new Response('Admin rights', 200);
        //}

        $params = $this->getRequest();
        $companyId = $params['companyId'];
        $em = $this->getDoctrine()->getManager();

        $company = $this->getDoctrine()
                ->getRepository('AppBundle:Company')
                ->find($companyId);

        if (!$company) {
            return new Response('Invalid company', 500);
        }

        if ($company->getSubscriptionId() != null && $company->getSubscriptionId() != '0') {
            $billing = $this->getBillingForCompany($company);
            if ($billing) {
                return new JsonResponse($billing);
            }
        }

//        $accountant = $this->getDoctrine()
//            ->getRepository('AppBundle:Employee')
//            ->findOneBy(['company' => $company, 'isDefaultAccountant' => true]);

        $accountant = $this->getDoctrine()
                ->getRepository('AppBundle:Employee')
                ->findOneBy(['company' => $company]);

        if (!$accountant) {
            return new Response('No default accountant', 500);
//            $accountant = $user;
        }

//        if (!$accountant->hasRole(Employee::$ROLE_ACCOUNTANT)) {
//            return new Response('User must be an accountant', 500);
//        }

        $curl = curl_init();

        $subscriptionData = [
            'subscription' => [
                'product_handle' => 'product_company',
                'customer_attributes' => [
                    'first_name' => $accountant->getUser()->getFirstName(),
                    'last_name' => $accountant->getUser()->getLastName(),
                    'email' => $accountant->getUser()->getEmail(),
                    'organization' => $company->getName()
                ],
                'components' => $this->getComponents($company)
            ]
        ];

        $data_string = json_encode($subscriptionData);

        curl_setopt($curl, CURLOPT_USERPWD, $this::curlChargifyAPIKey);
        curl_setopt($curl, CURLOPT_URL, $this::chargifySiteURL . '/subscriptions.json');
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return new Response("cURL Error #:" . $err, 500);
        }

        if (empty($response)) {
            return new Response('Empty response from Chargify API', 500);
        }

        // If using JSON...
        $json = json_decode($response, true);

        $subscription = $json['subscription'];
        if ($subscription) {
            // Save subscription id to company
            $company->setSubscriptionId($subscription['id']);

            // Save Billing Portal Link
//            $employee = $this->getDoctrine()
//                    ->getRepository('AppBundle:Employee')
//                    ->findOneBy(['company' => $company, 'user' => $this->getUser()]);

            $employee = $accountant;

            if (!$employee) {
                return new Response('Cannot find employee', 500);
            }

            $employee->setChargifyCustomerId($subscription['customer']['id']);

            $em->flush();

            return new JsonResponse($json);
        } else {
            return new Response('Error with billing', 500);
        }
    }

    /**
     * @Route("/api/billing/{id}/portal", name="apiBillingPortalRead")
     * @Method("GET")
     */
    public function readBillingPortalAction($id) {
        $em = $this->getDoctrine()->getManager();
        $company = $this->getDoctrine()
                ->getRepository('AppBundle:Company')
                ->find($id);

        if (!$company) {
            return new Response('Invalid company', 500);
        }

        $employee = $this->getDoctrine()
                ->getRepository('AppBundle:Employee')
                ->findOneBy(['company' => $company, 'user' => $this->getUser()]);

        if (!$employee) {
            return new Response('Cannot find employee', 500);
        }

        $customerId = $employee->getChargifyCustomerId();
        if (!$customerId) {
            return new Response('Current user has no chargify customer record', 500);
        }

        $billinkLink = $company->getBillingPortalLink();

        if (isset($billinkLink)) {
            return new Response($billinkLink);
        }


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this::chargifySiteURL . '/portal/customers/' . $customerId . '/management_link.json',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "{}",
            CURLOPT_USERPWD => $this::curlChargifyAPIKey
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return new Response("cURL Error #:" . $err, 500);
        }

        if (empty($response)) {
            return new Response('Empty response from Chargify API', 500);
        }


        // If using JSON...
        $json = json_decode($response, true);

        if (!isset($json['errors'])) {
            $url = $json['url'];
        } else {
            $url = false;
        }

        if ($url) {
            $company->setBillingPortalLink($billinkLink);
            $em->flush();

            return new Response($json['url']);
        } else {
            return new JsonResponse($json, 500);
        }
    }

    /**
     * This updates the subscription price
     * @Route("/api/billing/{id}/update", name="apiBillingUpdate")
     * @Method("GET")
     */
    public function updateBillingAction($id) {
        $company = $this->getDoctrine()
                ->getRepository('AppBundle:Company')
                ->find($id);

        if (!$company) {
            return new Response('Invalid company', 500);
        }

        $components = $this->getComponents($company);

        $response = '';

        foreach ($components as $component) {
            $curl = curl_init();

            // Product
            $subscriptionData = [
                'allocation' => [
                    'quantity' => $component['allocated_quantity'],
                    'proration_ugrade_scheme' => 'no-prorate',
                    'proration_downgrade_scheme' => 'no-prorate'
                ]
            ];

            $data_string = json_encode($subscriptionData);

            curl_setopt($curl, CURLOPT_USERPWD, $this::curlChargifyAPIKey);
            curl_setopt($curl, CURLOPT_URL, 'https://projectpro.chargify.com/subscriptions/' . $company->getSubscriptionId() . '/components/' . $component['component_id'] . '/allocations.json');
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

            $response .= $component['component_id'] . ': ' . curl_exec($curl);

            curl_close($curl);
        }

        return new Response($response);
    }

    /**
     * This updates the subscription billing date to the current datetime
     * @Route("/api/billing/{id}/activate", name="apiBillingActivate")
     * @Method("GET")
     */
    public function activateBillingAction($id) {
        $company = $this->getDoctrine()
                ->getRepository('AppBundle:Company')
                ->find($id);

        if (!$company) {
            return new Response('Invalid company', 500);
        }

        $curl = curl_init();

        // Product
        $subscriptionData = [
            'subscription' => [
                'next_billing_at' => date('n/j/Y H:i:s T')
            ]
        ];

        $data_string = json_encode($subscriptionData);

        curl_setopt($curl, CURLOPT_USERPWD, $this::curlChargifyAPIKey);
        curl_setopt($curl, CURLOPT_URL, 'https://projectpro.chargify.com/subscriptions/' . $company->getSubscriptionId() . '.json');
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return new Response("cURL Error #:" . $err, 500);
        }

        return new Response($response);
    }

    /**
     * @Route("/api/billing/{id}", name="apiBillingGet")
     * @Method("GET")
     */
    public function getBillingAction($id) {
        $company = $this->getDoctrine()
                ->getRepository('AppBundle:Company')
                ->find($id);

        if (!$company) {
            return new Response('Invalid company', 500);
        }

        return new JsonResponse($this->getBillingForCompany($company));
    }

    /**
     * @param Company $company
     * @return mixed|Response
     */
    private function getBillingForCompany($company) {
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

    /**
     * @param Company $company
     * @return array
     */
    private function getComponents($company) {
        $employees = $company->getEmployees();

        $qpacap = 0; // purchaser, accountant and approver
        $qpac = 0; // purchaser and accountant
        $qpap = 0; // purchaser and approver
        $qp = 0; // purchaaer only

        foreach ($employees as $employee) {
            if ($employee->getEnabled()) {
                if ($employee->hasRole(Employee::$ROLE_ACCOUNTANT) && $employee->hasRole(Employee::$ROLE_APPROVER)) {
                    $qpacap++;
                } elseif ($employee->hasRole(Employee::$ROLE_ACCOUNTANT)) {
                    $qpac++;
                } elseif ($employee->hasRole(Employee::$ROLE_APPROVER)) {
                    $qpap++;
                } else {
                    $qp++;
                }
            }
        }

        return [
            [
                'component_id' => 466114, // purchaser only
                'allocated_quantity' => $qp
            ],
            [
                'component_id' => 466116, // purchaser and approver
                'allocated_quantity' => $qpap
            ],
            [
                'component_id' => 466115, // purchaser and accountant
                'allocated_quantity' => $qpac
            ],
            [
                'component_id' => 466117, // purchaser, accountant and approver
                'allocated_quantity' => $qpacap
            ]
        ];
    }

}
