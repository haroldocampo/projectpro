<?php
/**
 * Created by PhpStorm.
 * User: marks
 * Date: 9/14/2017
 * Time: 6:49 PM
 */

namespace AppBundle\Controller\Api;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @deprecated
     * @Route("/api/users", name="apiUserNew")
     * @Method("POST")
     */
    public function newAction(Request $request)
    {
        $firstName = $request->request->get('firstName');
        $lastName = $request->request->get('lastName');
        $email = $request->request->get('email');
        $password = $request->request->get('password');
        $accountantEmail = $request->request->get('accountantEmail');

        $userManager = $this->get('fos_user.user_manager');
                
        $user = $this->em
        ->getRepository('AppBundle:User')
        ->create($userManager, $firstName, $lastName, $email, $password, $accountantEmail);        

        // send welcome mail
        $message = (new \Swift_Message('Welcome to ProjectPro!'))
            ->setFrom('credentials@projectprohub.com')
            ->setTo($email)
            ->setBody($this->renderView(
                'email/welcome_email.html.twig',
                array('user' => $user)),
                'text/html');

        $this->get('mailer')->send($message);

        return new Response('Created user ' . $user->getId(), 201);
    }
    
    /**
     * @Route("/api/users/{id}/resetpassword")
     * @Method("POST")
     */
    public function resetPasswordAction($id, Request $request)
    {
        $user = $this->findUser($id);

        $newPassword = $request->request->get('password');
        $user->setPlainPassword($newPassword);

        $userManager = $this->get('fos_user.user_manager');
        $userManager->updatePassword($user);

        return new JsonResponse([
            'success' => true,
            'message' => 'Updated password for User ' . $id
        ]);
    }

    /**
     * @Route("/api/users/{id}", name="apiUserShow")
     * @Method("GET")
     */
    public function showAction($id)
    {
        $user = $this->findUser($id);

        $json = $this->get('pp_util.handler')->serialize($user);

        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @Route("/api/users/{id}/companies", name="apiUserCompanyList")
     */
    public function listCompaniesAction($id) {
        $user = $this->findUser($id);    
        $isAdmin = $this->get('security.authorization_checker')->isGranted(User::ROLE_ADMIN);
        $companies = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->findCompanies($user, $isAdmin);
        // if ($this->get('security.authorization_checker')->isGranted(User::ROLE_ADMIN)) {
        //     $allCompanies = $this->getDoctrine()
        //         ->getRepository('AppBundle:Company')
        //         ->findBy([], ['name' => 'ASC']);

        //     foreach ($allCompanies as $company) {
        //         array_push($companies, [
        //             'id' => $company->getId(),
        //             'name' => $company->getName(),
        //             'employeeCount' => count($company->getEmployees()),
        //             'isAdmin' => false
        //         ]);
        //     }
        // } else {
        //     $employeeRecords = $this->getDoctrine()
        //         ->getRepository('AppBundle:Employee')
        //         ->findBy(['user' => $user]);

        //     foreach ($employeeRecords as $employeeRecord) {
        //         if($employeeRecord->getEnabled() == false){
        //             continue;
        //         }
        //         $company = $employeeRecord->getCompany();
        //         array_push($companies, [
        //             'id' => $company->getId(),
        //             'name' => $company->getName(),
        //             'employeeCount' => count($company->getEmployees()),
        //             'isAdmin' => false
        //         ]);
        //     }

        //     // sort
        //     $name = [];
        //     foreach ($companies as $key => $row) {
        //         $name[$key] = $row['name'];
        //     }
        //     array_multisort($name, SORT_ASC, $companies);

        // }

//        $administeredCompanies = $this->getDoctrine()
//            ->getRepository('AppBundle:Company')
//            ->findBy(['admin' => $user]);
//
//        foreach ($administeredCompanies as $administeredCompany) {
//            array_push($companies, [
//                'id' => $administeredCompany->getId(),
//                'name' => $administeredCompany->getName(),
//                'employeeCount' => count($administeredCompany->getEmployees()),
//                'isAdmin' => true
//            ]);
//        }

        return new JsonResponse($companies);
    }

    /**
     * @Route("/api/users", name="apiUserList")
     * @Method("GET")
     */
    public function listAction()
    {
        $users = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->findBy(['enabled' => 1]);

        $json = $this->get('pp_util.handler')->serialize($users);

        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @Route("/api/users/{id}", name="apiUserUpdate")
     * @Method({"PUT", "PATCH"})
     */
    public function updateAction($id, Request $request)
    {
        $params = $this->getRequest();
        $em = $this->getDoctrine()
            ->getManager();

        $user = $this->findUser($id);

        $firstName = $params['first_name'];
        if ($firstName) {
            $user->setFirstName($firstName);
        }

        $lastName = $params['last_name'];
        if ($lastName) {
            $user->setLastName($lastName);
        }

        $em->flush();

        return new JsonResponse('Updated user ' . $id, 200);
    }

    /**
     * @Route("/api/users/{id}", name="apiUserDelete")
     * @Method("DELETE")
     */
    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->findUser($id);

        $user->setEnabled(false);
        $em->flush();

        return new Response('Disabled user ' . $id, 204);
    }

    /**
     * @Route("/api/password/set", name="apiPasswordSet")
     * @Method("POST")
     */
    public function setPasswordAction(Request $request) {
        $password = $request->request->get('password');
        $userId = $request->request->get('userId');
        $token = $request->request->get('token');

        $user = $this->findUser($userId);

        if ($user->getPasswordSetToken() == $token) {
            $em = $this->getDoctrine()->getManager();
            $user->setPlainPassword($password)
                ->setPasswordSetToken(null);

            $em->flush();

            return new JsonResponse('Update password');
        } else {
            return new JsonResponse(false);
        }
    }

    /**
     * @Route("/api/users/{id}/setDone", name="apiSetDone")
     * @Method("POST")
     */
    public function setDoneAction($id, Request $request) {
        $type = $request->request->get('type');
        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->find($id);

        switch ($type) {
            case 'wizard':
                $user->setIsDoneWizard(true);
                break;
            case 'costCode':
                $user->setIsDoneCostCodeInstructions(true);
                break;
        }

        $em->flush();

        return new Response('Updated user');
    }
    
    /**
     * @Route("/api/users/current/setDone", name="apiCurrentSetDone")
     * @Method("POST")
     */
    public function setCurrentUserDoneAction($id, Request $request) {
        $params = $this->getRequest();
        $type = $params['type'];
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        switch ($type) {
            case 'wizard':
                $user->setIsDoneWizard(true);
                break;
            case 'costCode':
                $user->setIsDoneCostCodeInstructions(true);
                break;
        }

        $em->flush();

        return new Response('Updated user');
    }
    
    /**
     * @Route("/api/users/current/setDoneDuplicate", name="apiCurrentSetDoneDuplicate")
     * @Method("POST")
     */
    public function setCurrentUserDoneDuplicateAction(Request $request) {
        $params = $this->getRequest();
        $type = $params['type'];
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        switch ($type) {
            case 'wizard':
                $user->setIsDoneWizard(true);
                break;
            case 'costCode':
                $user->setIsDoneCostCodeInstructions(true);
                break;
        }

        $em->flush();

        return new Response('Updated user');
    }

    /**
     * @Route("/api/users/{id}/isDone", name="apiGetIsDone")
     * @Method("GET")
     */
    public function isDoneAction($id, Request $request) {
        $type = $request->request->get('type'); // wizard or costCode
        $user = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->find($id);

        switch ($type) {
            case 'wizard':
                $response = new JsonResponse([
                    'isDone' => $user->getIsDoneWizard()
                ]);
                break;
            case 'costCode':
                $response = new JsonResponse([
                    'isDone' => $user->getIsDoneCostCodeInstructions()
                ]);
                break;
            default:
                $response = new Response("Invalid type", 500);
        }
        return $response;
    }

    /**
     * @Route("/api/users/isDone/cci", name="apiIsDoneCCI")
     * @Method("GET")
     */
    public function isDoneCostCodeInstructions() {
        $user = $this->getUser();

        return new JsonResponse([
            'isDone' => $user->getIsDoneCostCodeInstructions()
        ]);
    }
    
    /**
     * @Route("/api/users/isDone/wizard", name="apiIsDoneWizard")
     * @Method("GET")
     */
    public function isDoneWizard() {
        $user = $this->getUser();

        return new JsonResponse([
            'isDone' => $user->getIsDoneWizard()
        ]);
    }

    /**
     * @param $id
     * @return \AppBundle\Entity\User|null|object
     */
    private function findUser($id)
    {
        $user = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                sprintf(
                    'No user found with id %s',
                    $id
                )
            );
        }

        return $user;
    }
    
    private function getRequest()
    {
        $params = array();
        $content = $this->container->get('request_stack')->getCurrentRequest()->getContent();

        if (!empty($content)) {
            $params = json_decode($content, true); // 2nd param to get as array
        }

        return $params;
    }

}