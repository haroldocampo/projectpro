<?php

namespace AppBundle\Controller\Web;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AccountController extends Controller
{
    /**
     * @Route("/account/login", name="loginPage")
     */
    public function loginAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('@FOSUser/Security/login.html.twig', []);
    }
    
    /**
     * @Route("/account/register", name="registerPage")
     */
    public function registerAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('@FOSUser/Registration/register.html.twig', []);
    }

    /**
     * @Route("/account/register/check_email", name="registerCheckEmail")
     */
    public function registerCheckEmail() {
        return $this->render('@FOSUser/Registration/check_email.html.twig');
    }
    
    /**
     * @Route("/account/register/errors", name="registerErrors")
     */
    public function registerErrors(Request $request) {
        return $this->render('@FOSUser/Registration/register_errors.html.twig', ['error' => $request->query->get('error')]);
    }
    
    /**
     * @Route("/account/forgot", name="forgotPasswordPage")
     */
    public function forgotPasswordAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('@FOSUser/Resetting/request.html.twig', []);
    }
    
    /**
     * @Route("/account/reset", name="resetPasswordPage")
     */
    public function resetPasswordAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('account/reset.html.twig', []);
    }

    /**
     * @Route("/account/reset/confirmed", name="resetPasswordConfirmed")
     */
    public function resetPasswordConfirmedAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('@FOSUser/Resetting/reset_confirm.html.twig');
    }

    /**
     * @Route("/account/password/set", name="accountSetPassword")
     */
    public function setPasswordAction(Request $request) {
        $token = $request->query->get('t');
        $userId = $request->query->get('uid');

        $user = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->find($userId);

        if (!$user) {
            // TODO: create error dialog/page
            throw $this->createNotFoundException(
                sprintf(
                    'No user found with id %s',
                    $userId
                )
            );
        }

        if ($user->getPasswordSetToken() != $token) {
            throw $this->createNotFoundException(
                sprintf(
                    'No user found with token %s',
                    $token
                )
            );
        }

        $error = $this->get('session')->getFlashBag()->get('error_set_password');

        return $this->render('account/set_password.html.twig', [
            'user' => $user,
            'token' => $token,
            'userId' => $userId,
            'error' => $error
        ]);
    }

    /**
     * @Route("/account/password/set_check", name="accountSetPasswordCheck")
     * @Method("POST")
     */
    public function setPasswordCheckAction(Request $request) {
        $firstName = $request->request->get('firstName');
        $lastName = $request->request->get('lastName');
        $password = $request->request->get('password');
        $cPassword = $request->request->get('confirmPassword');
        $token = $request->request->get('token');
        $userId = $request->request->get('userId');

        $user = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->find($userId);

        if (!$user) {
            throw $this->createNotFoundException(
                sprintf(
                    'No user found with id %s',
                    $userId
                )
            );
        }

        if ($password != $cPassword) {
            // error password
            $this->addFlash('error_set_password', 'Password mismatch');
            return $this->redirectToRoute('accountSetPassword');
        }

        $userManager = $this->get('fos_user.user_manager');
        
        $user->setPlainPassword($password)
            ->setFirstName($firstName)
            ->setLastName($lastName);
        $userManager->updateUser($user);

        // TODO: success page
//        return $this->redirectToRoute('fos_user_security_login');
        return $this->redirect("https://projex.app.link/PoDvtEUVBM");
    }


}
