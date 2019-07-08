<?php

namespace AppBundle\Controller\Web;

use AppBundle\Entity\Employee;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class DashboardController extends Controller {

    /**
     * @Route("/dashboard/approver", name="approverPage")
     */
    public function ApproverAction(Request $request) {
        return $this->render('dashboard/approver.html.twig', []);
    }

    /**
     * @Route("/dashboard/accountant", name="accountantPage")
     */
    public function AccountantAction(Request $request) {
        return $this->render('dashboard/accountant.html.twig', []);
    }

    /**
     * @Route("/dashboard", name="dashboardPage")
     */
    public function indexAction(Request $request) {
        $user = $this->getUser();

        $employeeRecords = $this->getDoctrine()
                ->getRepository('AppBundle:Employee')
                ->findBy(['user' => $user]);

        if (count($employeeRecords) >= 1) {
            // show companies page
            $companyId = $employeeRecords[0]->getCompany()->getId();            

            foreach ($employeeRecords as $er) {
                if ($er->getEnabled()) {
                    $companyId = $er->getCompany()->getId();
                    break;
                }
            }

            return $this->redirectToRoute('showCompanyDashboard', ['id' => $companyId]);
        } elseif (count($employeeRecords) == 0) {
            if ($user->hasRole(User::ROLE_ADMIN)) {
                $companies = $this->getDoctrine()->getRepository('AppBundle:Company')
                    ->findAll();
                return $this->redirectToRoute('showCompanyUserDashboard', ['id' => $companies[0]->getId()]);
            } else {
                $this->get('security.token_storage')->setToken(null);
                return $this->render('error/purchaser_error.html.twig', [
                    'message' => 'Oops! You don\'t have permissions to log into ProjectPro. If you are trying to submit a purchase, please do so from our mobile app, Projex. If you would like to log into ProjectPro as an Approver or an Accountant, please contact an Administrator in your company and ask them to update your permissions. Error: No company account found'
                ]);
            }
        }

        $companyId = $employeeRecords[0]->getCompany()->getId();

        return $this->redirectToRoute('showCompanyDashboard', ['id' => $companyId]);

        // TODO: show all companies page if multiple
//        return $this->render('dashboard/company_list.html.twig');
//        $companyId = $administeredCompanies[0]->getId();
//        if (count($employeeRecords) == 0) {
//            $userAdmins = $this->getDoctrine()
//                ->getRepository('AppBundle:Employee')
//                ->findAdminsByUser($user);
//
//            if (count($userAdmins) >= 1) {
//                $companyId = $userAdmins[0]->getCompany()->getId();
//
//                return $this->redirectToRoute('showCompanyDashboard', ['id' => $companyId]);
//            }
//
//            // TODO: Show own company of not employed to other companies
//        }
//
//        // TODO: create company list page
//        return $this->render('default/index.html.twig', []);
    }

    /**
     * @Route("/dashboard/setupwizard/company/{id}/{employeeId}", name="showSetupWizardDashboard")
     */
    public function showSetupWizardAction($id, $employeeId) {
        $company = $this->getDoctrine()
                ->getRepository('AppBundle:Company')
                ->find($id);

        if (!$company) {
            throw $this->createNotFoundException(
                    sprintf(
                            'No company found with id %s', $id
                    )
            );
        }

        $user = $this->getUser();

        $em = $this->getDoctrine()
                ->getManager();

        $e = $this->getDoctrine()
                ->getRepository('AppBundle:Employee')
                ->findBy(['id' => $employeeId])[0];

        $e->setIsDoneWizard(false);

        $em->flush();

        return $this->redirectToRoute('showCompanyUserDashboard', ['id' => $id]);
    }

    /**
     * @Route("/dashboard/admin/users/{id}", name="dashboardAdminUsersCompanyPage")
     */
    public function dashboardAdminUsersAction($id, Request $request) {
        $user = $this->getUser();

        $employeeRecords = $this->getDoctrine()
                ->getRepository('AppBundle:Employee')
                ->findBy(['user' => $user]);

//            $userAdmins = $this->getDoctrine()
//                ->getRepository('AppBundle:Employee')
//                ->findAdminsByUser($user); // TODO: fix repo

//        $administeredCompanies = [];
//        foreach ($employeeRecords as $employee) {
//            if ($employee->hasRole(Employee::$ROLE_ADMIN)) {
//                array_push($administeredCompanies, $employee->getCompany());
//            }
//        }

//            if (count($userAdmins) == 1) {
//                $companyId = $userAdmins[0]->getCompany()->getId();
//            }

        $companyId = $id;

        return $this->redirectToRoute('showCompanyUserDashboard', ['id' => $companyId]);

//        return $this->render(
//            'admin/users.html.twig',
//            ['companyId' => $companyId]
//        ); // TODO: show all companies page if multiple
//        if(isset($companyId)){
//            return $this->render('admin/users.html.twig', ['companyId' => $companyId]);
//        }
//        return $this->render('default/index.html.twig', []);
    }

    /**
     * @Route("/dashboard/admin/users", name="dashboardAdminUsersPage")
     */
    public function adminUsersAction(Request $request) {
        $user = $this->getUser();

        $employeeRecords = $this->getDoctrine()
                ->getRepository('AppBundle:Employee')
                ->findBy(['user' => $user]);
        
        $administeredCompanies = [];
        foreach ($employeeRecords as $employee) {
            if ($employee->hasRole(Employee::$ROLE_ADMIN)) {
                array_push($administeredCompanies, $employee->getCompany());
            }
        }

        $companyId = $administeredCompanies[0]->getId();

        return $this->redirectToRoute('showCompanyUserDashboard', ['id' => $companyId]);
    }

    /**
     * @Route("/dashboard/company/{id}", name="showCompanyDashboard")
     */
    public function showCompanyAction($id, Request $request) {
        $company = $this->getDoctrine()
                ->getRepository('AppBundle:Company')
                ->find($id);

        $error = $request->query->get('error');

        if (!$company) {
            throw $this->createNotFoundException(
                    sprintf(
                            'No company found with id %s', $id
                    )
            );
        }

        $user = $this->getUser();
        // bypass for super admin
        if ($user->hasRole(User::ROLE_ADMIN)) {
            return $this->redirectToRoute('showCompanyUserDashboard', ['id' => $id, 'error' => $error]);
        }

        $employee = $this->getDoctrine()
                ->getRepository('AppBundle:Employee')
                ->findOneBy(['company' => $company, 'user' => $user]);



        if (!$employee) {
            throw $this->createNotFoundException(
                    sprintf(
                            'No employee record found for User %s', $user->getId()
                    )
            );
        }

        $companyId = $company->getId();
        
        if (!$employee->getIsDoneWizard() && $employee->hasRole(Employee::$ROLE_ADMIN)) {
            return $this->redirectToRoute('showCompanyUserDashboard', ['id' => $companyId, 'company' => $company, 'error' => $error]);
        }

        if ($employee->hasRole(Employee::$ROLE_ACCOUNTANT)) {
            return $this->redirectToRoute('showCompanyAccountantDashboard', ['id' => $companyId, 'error' => $error]);
        } elseif ($employee->hasRole(Employee::$ROLE_APPROVER)) {
            return $this->redirectToRoute('showCompanyApproverDashboard', ['id' => $companyId, 'error' => $error]);
        } elseif ($employee->hasRole(Employee::$ROLE_ADMIN)) {

            return $this->redirectToRoute('showCompanyAdminDashboard', ['id' => $companyId, 'error' => $error]);
        } else {
            $this->get('security.token_storage')->setToken(null);
//            throw new AccessDeniedHttpException("Oops! You don't have permissions to log into ProjectPro. If you are trying to submit a purchase, please do so from our mobile app, Projex. If you would like to log into ProjectPro as an Approver or an Accountant, please contact an Administrator in your company and ask them to update your permissions.");
            return $this->render('error/purchaser_error.html.twig', [
                        'message' => 'Oops! You don\'t have permissions to log into ProjectPro. If you are trying to submit a purchase, please do so from our mobile app, Projex. If you would like to log into ProjectPro as an Approver or an Accountant, please contact an Administrator in your company and ask them to update your permissions.'
            ]);
        }
    }

    private function getEmployeeRecord($companyId) {
        if ($companyId) {
            $user = $this->getUser();
            $company = $this->getDoctrine()
                ->getRepository('AppBundle:Company')
                ->find($companyId);
            $employeeRecord = $this->getDoctrine()
                ->getRepository('AppBundle:Employee')
                ->findOneBy(['user' => $user, 'company' => $company]);

            return $employeeRecord;
        } else {
            return null;
        }
    }

    /**
     * @Route("/dashboard/company/{id}/accountant", name="showCompanyAccountantDashboard")
     */
    public function showCompanyAccountantAction($id, Request $request) {
        $employeeRecord = $this->getEmployeeRecord($id);
        $employeeId = null;
        if ($employeeRecord) {
            $employeeId = $this->getEmployeeRecord($id)->getId();
        }
        $isQbIntegrated = $this->getDoctrine()
            ->getRepository('AppBundle:Company')
            ->find($id)
            ->isQbIntegrated();
            
        return $this->render(
                        'dashboard/accountant.html.twig', ['companyId' => $id, 'isQbIntegrated' => $isQbIntegrated,  'employeeRecord' => $employeeRecord, 'employeeId' => $employeeId,
                'error' => $request->query->get('error')]
        );
    }
    
    /**
     * @Route("/dashboard/company/{id}/account", name="showCompanyAccountDashboard")
     */
    public function showCompanyAccountAction($id, Request $request) {
        $employeeRecord = $this->getEmployeeRecord($id);
        $employeeId = null;
        if ($employeeRecord) {
            $employeeId = $this->getEmployeeRecord($id)->getId();
        }
        $isQbIntegrated = $this->getDoctrine()
            ->getRepository('AppBundle:Company')
            ->find($id)
            ->isQbIntegrated();

        return $this->render(
                        'dashboard/account.html.twig', ['companyId' => $id, 'isQbIntegrated' => $isQbIntegrated,  'employeeRecord' => $employeeRecord, 'employeeId' => $employeeId,
                'error' => $request->query->get('error')]
        );
    }

    /**
     * @Route("/dashboard/company/{id}/paymenttypes", name="showCompanyPaymentTypesDashboard")
     */
    public function PaymentTypesAction($id) {
        $isQbIntegrated = $this->getDoctrine()
            ->getRepository('AppBundle:Company')
            ->find($id)
            ->isQbIntegrated();

        return $this->render(
                        'dashboard/paymenttype_list.html.twig', ['companyId' => $id, 'isQbIntegrated' => $isQbIntegrated,  'employeeRecord' => $this->getEmployeeRecord($id)]
        );
    }

    /**
     * @Route("/dashboard/company/{id}/classes", name="classesCompanyDashboard")
     */
    public function classesAction($id) {
        $isQbIntegrated = $this->getDoctrine()
            ->getRepository('AppBundle:Company')
            ->find($id)
            ->isQbIntegrated();

        return $this->render(
                        'dashboard/class_list.html.twig', ['companyId' => $id, 'isQbIntegrated' => $isQbIntegrated,  'employeeRecord' => $this->getEmployeeRecord($id)]
        );
    }

    /**
     * @Route("/dashboard/company/{id}/vendors", name="vendorsCompanyDashboard")
     */
    public function vendorsAction($id) {
        $isQbIntegrated = $this->getDoctrine()
            ->getRepository('AppBundle:Company')
            ->find($id)
            ->isQbIntegrated();

        return $this->render(
                        'dashboard/vendor_list.html.twig', ['companyId' => $id, 'isQbIntegrated' => $isQbIntegrated,  'employeeRecord' => $this->getEmployeeRecord($id), 'EmployeeId' => $this->getEmployeeRecord($id)->getId()]
        );
    }


    /**
     * @Route("/dashboard/company/{id}/approver", name="showCompanyApproverDashboard")
     */
    public function showCompanyApproverAction($id, Request $request) {
        $employeeRecord = $this->getEmployeeRecord($id);
        $employeeId = null;
        if ($employeeRecord) {
            $employeeId = $this->getEmployeeRecord($id)->getId();
        }
        $isQbIntegrated = $this->getDoctrine()
            ->getRepository('AppBundle:Company')
            ->find($id)
            ->isQbIntegrated();

        return $this->render(
                        'dashboard/approver.html.twig', [
                    'companyId'      => $id,
                    'isQbIntegrated' => $isQbIntegrated,
                    'employeeRecord' => $employeeRecord,
                    'employeeId'     => $employeeId,
                    'helpcontent'    => 'yep',
                            'error'  => $request->query->get('error')
                        ]
        );
    }

    /**
     * @Route("/dashboard/company/{id}/users", name="showCompanyUserDashboard")
     */
    public function showCompanyUserAction($id, Request $request) {
        $employeeRecord = $this->getEmployeeRecord($id);
        if ($employeeRecord) {
            $employeeId = $employeeRecord->getId();
        } else {
            $employeeId = null;
        }
        $isQbIntegrated = $this->getDoctrine()
            ->getRepository('AppBundle:Company')
            ->find($id)
            ->isQbIntegrated();

        return $this->render(
                        ':dashboard:employee_list.html.twig', ['companyId' => $id, 'isQbIntegrated' => $isQbIntegrated,  'isQbIntegrated' => $isQbIntegrated ,'employeeRecord' => $employeeRecord, 'employeeId' => $employeeId,
                'error' => $request->query->get('error')]
        );
    }

    /**
     * @Route("/dashboard/company/{id}/admin", name="showCompanyAdminDashboard")
     */
    public function showCompanyAdminAction($id, Request $request) {
        // TODO: #HAROLD - create UI for company admin
        $isQbIntegrated = $this->getDoctrine()
            ->getRepository('AppBundle:Company')
            ->find($id)
            ->isQbIntegrated();
        return $this->render(
                        'dashboard/admin.html.twig', ['companyId' => $id, 'isQbIntegrated' => $isQbIntegrated,  'employeeRecord' => $this->getEmployeeRecord($id),
                'error' => $request->query->get('error')]
        );
    }

    /**
     * @Route("/dashboard/test", name="dashboardTestPage")
     */
    public function testDashboardAction(Request $request) {
        return new JsonResponse(
                [
            'success' => $this->getUser()->getCompany()->getId(),
                ]
        );
    }

}
