<?php

namespace AppBundle\Controller\Web;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // Temporarily redirect to dashboard
        return $this->redirectToRoute('dashboardPage');
    }

    /**
     * @Route("/mobile/invalid_device", name="defaultInvalidDevice")
     */
    public function mobileRedirect() {
        return $this->render('error/invalid_device.html.twig');
    }
}
