<?php

namespace AppBundle\Controller\Web;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProjectController extends Controller
{
    /**
     * @Route("/project/{id}", name="projectPage")
     */
    public function DetailsAction($id, Request $request)
    {
        return $this->render('project/details.html.twig', []);
    }
}
