<?php

namespace AppBundle\Controller\Web;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BillingController extends Controller
{
    /**
     * @Route("/employeeRoles", name="employeeRolesPage")
     */
    public function indexAction($name)
    {
        return $this->render(':admin:employee_role.html.twig');
    }
}
