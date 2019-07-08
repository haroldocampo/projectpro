<?php

/**
 * Created by PhpStorm.
 * User: marks
 * Date: 9/19/2017
 * Time: 8:00 AM
 */

namespace AppBundle\EventListener;

use AppBundle\Entity\Company;
use AppBundle\Entity\Employee;
use AppBundle\Entity\PaymentType;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RegistrationListener implements EventSubscriberInterface {

    private $router;
    private $em;
    private $mailer;
    private $templating;
    private $userManager;
    private $employeeHandler;

    const curlChargifyAPIKey = 'DaacmafsgJFjFumNW0kbCeZzDqxG8zJT3TWqAmSLm8:x';
    const chargifySiteURL = 'https://projectpro.chargify.com';

    /**
     * RegistrationListener constructor.
     * @param UrlGeneratorInterface $router
     * @param EntityManagerInterface $entityManager
     * @param ContainerInterface $container
     */
    public function __construct(UrlGeneratorInterface $router, EntityManagerInterface $entityManager, ContainerInterface $container) {
        $this->router = $router;
        $this->em = $entityManager;
        $this->mailer = $container->get('mailer');
        $this->templating = $container->get('templating');
        $this->userManager = $container->get('fos_user.user_manager');
        $this->employeeHandler = $container->get('pp_employee.handler');
    }

    /**
     * (@inheritdoc)
     */
    public static function getSubscribedEvents() {
        return [
            FOSUserEvents::REGISTRATION_INITIALIZE => 'onRegistrationInitialize',
            FOSUserEvents::REGISTRATION_SUCCESS => [
                ['onRegistrationSuccess', -10],
            ],
            FOSUserEvents::REGISTRATION_COMPLETED => 'onRegistrationCompleted',
//            FOSUserEvents::REGISTRATION_CONFIRMED => 'onRegistrationConfirmed'
        ];
    }

    public function onRegistrationInitialize(UserEvent $event) {
//        $event->getUser()->setPlainPassword(uniqid());
        $event->getUser()->setPlainPassword('secretpassword');
    }

    /**
     * @param FormEvent $event
     */
    public function onRegistrationSuccess(FormEvent $event) {
        $user = $event->getRequest()->request->get('fos_user_registration_form');
        // create company
        $companyName = $event->getRequest()->request->get('companyName');

        $company = $this->em->getRepository('AppBundle:Company')->findOneBy(['name' => $companyName]);

        if (isset($company)) {
            return;
            $url = $this->router->generate('registerErrors');
            $event->setResponse(new RedirectResponse($url . '?error=Company name already exists for ' . $companyName));
        }

        $company = new Company();
        $company->setName($companyName);
        $this->em->persist($company);

        // Create Subscription and Billing
        $curl = curl_init();
        //$nextMonthDay = (int)date('d', strtotime('+1 months'));
        //$nextMonthDay = $nextMonthDay > 28 ? 'end' : $nextMonthDay;
        $subscriptionData = [
            'subscription' => [
                'product_handle' => 'product_company',
                'customer_attributes' => [
                    'first_name' => $user['firstName'],
                    'last_name' => $user['lastName'],
                    'email' => $user['email'],
                    'organization' => $company->getName()
                ],
                'components' => $this->getComponents($company),
                //'next_billing_at' => $nextMonth,
                //'snap_day' => --$nextMonthDay,
                'calendar_billing_first_charge' => 'delayed'
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

        // If using JSON...
        $json = json_decode($response, true);
        $subscription = $json['subscription'];
        if ($subscription) {
            // Save subscription id to company
            $company->setSubscriptionId($subscription['id']);

            $this->em->flush();
        }

        $billingResponse = $this->processBilling($event, $company->getId());

        if ($billingResponse['success']) {
            $url = $this->router->generate('registerCheckEmail');
            $event->setResponse(new RedirectResponse($url));
        } else {
            $url = $this->router->generate('registerErrors');
            $event->setResponse(new RedirectResponse($url . '?error=' . $billingResponse['error']));
        }
    }

    /**
     * @param FilterUserResponseEvent $event
     */
    public function onRegistrationCompleted(FilterUserResponseEvent $event) {
        $user = $event->getUser();

        $eUser = $this->em->getRepository('AppBundle:User')->findOneBy(['email' => $user->getEmail()]);

        // Prevents duplicate calls
        if ($eUser->getPasswordSetToken() != null) {
            return;
        }

        // Check Company
        $companyName = $event->getRequest()->request->get('companyName');
        $company = $this->em->getRepository('AppBundle:Company')->findOneBy(['name' => $companyName]);

        $subscription = $this->getBillingForCompany($company);

        if (!isset($subscription['subscription']['credit_card'])) { // IF Credit Card Validation Failed, delete the subscription
            $this->deleteSubscription($subscription['subscription']['id']);
            return;
        }


        $token = $this->generateRandomString();
        $user->setPasswordSetToken($token);
        $this->em->flush($user);

        // create default payment types
//        $pmNet30 = new PaymentType();
//        $pmNet30->setName("NET 30")
//            ->setCompany($company);
//        $this->em->persist($pmNet30);
//
//        $pmPO = new PaymentType();
//        $pmPO->setName("PO")
//            ->setCompany($company);
//        $this->em->persist($pmPO);
//
//        $pmCash = new PaymentType();
//        $pmCash->setName("Cash")
//            ->setCompany($company);
//        $this->em->persist($pmCash);

        $pmReimbursement = new PaymentType();
        $pmReimbursement->setName("Reimbursement")
                ->setCompany($company);
        $this->em->persist($pmReimbursement);

        // create admin employee
//        $employee = new Employee();
//        $employee->setCompany($company)
//            ->setUser($user)
//            ->addRole(Employee::$ROLE_ADMIN);
        // Check if accountant is existing
        $accountantEmail = $event->getRequest()->request->get('accountantEmail');
        $isDefaultAcc = false;
        if ($accountantEmail == $user->getEmail()) {
            $isDefaultAcc = true;
        }

        $employee = $this->em->getRepository('AppBundle:Employee')
                ->create($user, $company, ['admin'], $isDefaultAcc);

        $message = (new \Swift_Message('Welcome to ProjectPro!'))
                ->setFrom('credentials@projectprohub.com')
                ->setTo($user->getEmail())
                ->setBody($this->templating->render(
                        'email/welcome_email.html.twig', ['user' => $user, 'passwordSetUrl' => $this->generatePasswordSetUrl($user->getId(), $user->getPasswordSetToken())]), 'text/html');

        $this->mailer->send($message);


        if ($accountantEmail) {
            $accountantUser = $this->em->getRepository('AppBundle:User')->findOneBy(['email' => $accountantEmail]);
            if (!$accountantUser) {
                // not existing
                // create user then send email with set token
                $accountantUser = $this->userManager->createUser();
                $accountantUser->setEmail($accountantEmail)
                        ->setPlainPassword('secretpassword')
                        ->setEnabled(true)
                        ->setPasswordSetToken($this->generateRandomString())
                        ->setFirstName('')
                        ->setLastName('');

                $this->userManager->updateUser($accountantUser);
            }

            // create employee record
            $this->employeeHandler->createEmployee($accountantUser, $company, $user, ['accountant', 'approver'], true);
        }
        $accountant = $employee;

        $employee->setChargifyCustomerId($subscription['subscription']['customer']['id']);
        $this->em->flush();
    }

    private function processBilling(FormEvent $event, $companyId) {
        $request = $event->getRequest();
        $nonce = $request->request->get('nonce');
        $billingAddress = $request->request->get('billingAddress');
        $billingCity = $request->request->get('billingCity');
        $billingState = $request->request->get('billingState');
        $billingCountry = $request->request->get('billingCountry');
        $billingEmail = $request->request->get('billingEmail');
        $billingZip = $request->request->get('billingZip');

        $company = $this->em
                ->getRepository('AppBundle:Company')
                ->find($companyId);

        if (!$company) {
            return ['error' => 'Invalid Company', 'success' => false];
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

        if ($err) {
            return ['error' => "cURL Error #:" . $err, 'success' => false];
        }
        $json = json_decode($response, true);
        if (array_key_exists('errors', $json)) {
            return ['error' => $json["errors"][0], 'success' => false];
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

        if ($err) {
            return ['error' => "cURL Error #:" . $err, 'success' => false];
        }

        if (array_key_exists('errors', $json)) {
            return ['error' => $json["errors"][0], 'success' => false];
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
            return ['error' => "cURL Error #:" . $err, 'success' => false];
        }

        $customerUpdateJson = json_decode($response, true);
        // End of update customer

        if ($subscription["subscription"]["state"] === 'past_due') {
            $curl = curl_init();

            curl_setopt($curl, CURLOPT_USERPWD, $this::curlChargifyAPIKey);
            curl_setopt($curl, CURLOPT_URL, 'https://projectpro.chargify.com/subscriptions/' . $subscriptionId . '/retry.json');
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
        } else {
            // THIS AREA IS COMMENTED BECAUSE WE DONT WANT TO BILL immediately
            // 
//            // update billing to date now
//            $updatedSubscription = [
//                'subscription' => [
//                    'next_billing_at' => (new \DateTime())->format('n/j/Y H:i:s T'),
////                'next_billing_at' => 'NOW',
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
//                return ['error' => "cURL Error #:" . $err, 'success' => false];
//            }
        }

        return ['success' => true];
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

        if ($qpacap <= 0) {
            // This should always be 1, ever since the new registration
            // System creates the subscription first before creating employees therefore this will always default to 1
            $qpacap = 1;
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

//    public function onRegistrationConfirmed(FilterUserResponseEvent $event) {
//        // create company
//        $companyName = $event->getRequest()->request->get('companyName');
//        $user = $event->getUser();
//
//        $token = $this->generateRandomString();
//        $user->setPasswordSetToken($token);
//        $this->em->flush($user);
//
//        $company = new Company();
//        $company->setName($companyName)
//            ->addAdmin($user);
//        $this->em->persist($company);
//        $this->em->flush($company);
//
//        $message = (new \Swift_Message('Welcome to ProjectPro!'))
//            ->setFrom('no-reply@projectprohub.com')
//            ->setTo($user->getEmail())
//            ->setBody($this->templating->render(
//                'email/welcome_email.html.twig',
//                ['user' => $user, 'passwordSetUrl' => $this->generatePasswordSetUrl($user->getId(), $user->getPasswordSetToken())]),
//                'text/html');
//
//        $this->mailer->send($message);
//
//        // Check if accountant is existing
//        $accountantEmail = $event->getRequest()->request->get('accountantEmail');
//
//        if ($accountantEmail) {
//            $existingUser = $this->em->getRepository('AppBundle:User')->findOneBy(['email' => $accountantEmail]);
//            if ($existingUser) {
//                // existing
//                // send email without set token
//                $accountantMessage = (new \Swift_Message('Welcome to ProjectPro!'))
//                    ->setFrom('no-reply@projectprohub.com')
//                    ->setTo($user->getEmail())
//                    ->setBody($this->templating->render(
//                        'email/welcome_email_accountant.html.twig',
//                        [
//                            'user' => $existingUser,
//                            'passwordSetUrl' => null,
//                            'companyName' => $companyName,
//                            'admin' => $user
//                        ]),
//                        'text/html'
//                    );
//
//                $this->mailer->send($accountantMessage);
//            } else {
//                // not existing
//                // create user then send email with set token
//                $accountantUser = $this->userManager->createUser();
//                $accountantUser->setEmail($accountantEmail)
//                    ->setPlainPassword('test')
//                    ->setEnabled(true)
//                    ->setPasswordSetToken($this->generateRandomString())
//                    ->setFirstName('')
//                    ->setLastName('');
//
//                $this->userManager->updateUser($accountantUser);
//
//                // create employee record
//                $this->employeeHandler->createEmployee($accountantUser, $company, [Employee::$ROLE_ACCOUNTANT]);
//
//                $accountantMessage = (new \Swift_Message('Welcome to ProjectPro!'))
//                    ->setFrom('no-reply@projectprohub.com')
//                    ->setTo($accountantUser->getEmail())
//                    ->setBody($this->templating->render(
//                        'email/welcome_email_accountant.html.twig',
//                        [
//                            'user' => $accountantUser,
//                            'passwordSetUrl' => $this->generatePasswordSetUrl($accountantUser->getId(), $accountantUser->getPasswordSetToken()),
//                            'companyName' => $companyName,
//                            'admin' => $user
//                        ]),
//                        'text/html'
//                    );
//
//                $this->mailer->send($accountantMessage);
//            }
//        }
//    }

    private function deleteSubscription($id) {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_USERPWD, $this::curlChargifyAPIKey);
        curl_setopt($curl, CURLOPT_URL, 'https://projectpro.chargify.com//subscriptions/' . $id . '.json');
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        return;
    }

    /**
     * @param int $length
     * @return bool|string
     */
    private function generateRandomString($length = 24) {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }

    /**
     * @param $userId
     * @param $passwordSetToken
     * @return string
     */
    private function generatePasswordSetUrl($userId, $passwordSetToken) {
        return $this->router->generate('accountSetPassword', [], UrlGeneratorInterface::ABSOLUTE_URL) . '?uid=' . $userId . '&t=' . $passwordSetToken;
    }

}
