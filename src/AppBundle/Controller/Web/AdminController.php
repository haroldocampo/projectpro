<?php

namespace AppBundle\Controller\Web;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    /**
     * @Route("/admin/users", name="usersPage")
     */
    public function usersAction(Request $request)
    {
        return $this->render('admin/users.html.twig', []);
    }
    
    
    
}
