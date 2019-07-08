<?php

/**
 * Created by PhpStorm.
 * User: marks
 * Date: 9/14/2017
 * Time: 7:25 PM
 */

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Cost;
use AppBundle\Entity\Project;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\MimeType\FileinfoMimeTypeGuesser;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends Controller {

    /**
     * @Route("/api/projects", name="apiProjectNew")
     * @Method("POST")
     */
    public function newAction(Request $request) {
        $params = $this->getRequest();
        $em = $this->getDoctrine()->getManager();
        $name = $params['name'];
        $customer = isset($params['customer']) ? $params['customer'] : '';
        $number = isset($params['number'])  ? $params['number'] : '';
        $approver = $params['approver'];
        $isNewApprover = $params['isNewApprover'];
        $company = $this->get('pp_util.handler')->getCompany($params['companyId']);

        $isDuplicate = $this->getDoctrine()
        ->getRepository('AppBundle:Project')
        ->isDuplicateName($name);        

        if($isDuplicate){
            return new JsonResponse([
                'success' => false,
                'message' => "Project Name is Already Taken",
                'duplicate' => true,                
            ]);
        }


        if ($params['isNewApprover'] == false) {
            $approverId = $approver['id'];
        } else {
            $firstName = $approver['firstName'];
            $lastName = $approver['lastName'];
            $email = $approver['email'];

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return new JsonResponse([
                    'success' => false,
                    'duplicate' => false,
                    'message' => "Invalid email format"
                ]);
            }

            $existingUser = $this->getDoctrine()
                    ->getRepository('AppBundle:User')
                    ->findOneBy(['email' => $email]);

            if (!$existingUser) {
                $userManager = $this->get('fos_user.user_manager');

                $user = $userManager->createUser();
                $user->setEmail($email)
                        ->setPlainPassword('secretpassword')
                        ->setEnabled(true)
                        ->setFirstName($firstName)
                        ->setLastName($lastName);

                $userManager->updateUser($user);
            } else {
                $user = $existingUser;
            }

            $employee = $this->get('pp_employee.handler')->createEmployee($user, $company, $this->getUser(), ['approver']);
            $approverId = $employee->getId();
        }


        $approver = $this->getDoctrine()
                ->getRepository('AppBundle:Employee')
                ->find($approverId);

        // $project = new Project();
        // $project->setName($name)
        //         ->setNumber($number)
        //         ->setApprover($approver)
        //         ->setCompany($company);

        // $em->persist($project);        
        
        $em->flush();
        
        $project = $this->getDoctrine()
            ->getRepository('AppBundle:Project')
            ->create($customer, $name, $number, $approver, $company);
        
        $response = new Response('It worked.', 201);
        $projectUrl = $this->generateUrl(
                'apiProjectShow', ['id' => $project->getId()]
        );
        $response->headers->set('Location', $projectUrl);

        return new JsonResponse([
            'success' => true,
            'message' => "Project Added",
            'projectId' => $project->getId()
        ]);
    }

    /**
     * @Route("/api/projects/{id}", name="apiProjectShow")
     * @Method("GET")
     */
    public function showAction($id) {
        $project = $this->getProject($id);

        $costs = $project->getCosts();
        $result = ['project' => $project, 'costs' => $costs];
        $r = $this->get('pp_util.handler')->serialize($result);

        return new JsonResponse($r, 200, [], true);
    }

    /**
     * @Route("/api/projects", name="apiAllProjectList")
     * @Method("GET")
     */
    public function listAction(Request $request) {
        $projects = $this->getDoctrine()
                ->getRepository('AppBundle:Project')
                ->findAll();

//        $hasBudget = array();
//        $hasNoBudget = array();
//        foreach($projects as $p){
//            if(count($p->getCosts()) > 0){
//                $hasBudget[] = $p;
//            } else {
//                $hasNoBudget[] = $p;
//            }
//        }

        $json = $this->get('pp_util.handler')->serialize(['projects' => $projects]);

        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @Route("/api/projects/{id}", name="apiProjectUpdate")
     * @Method({"PUT", "PATCH"})
     */
    public function updateAction($id, Request $request) {
        $params = $this->getRequest();
        $em = $this->getDoctrine()->getManager();
        $project = $this->getProject($id);

        $costs = $params['costs'];                
        $name = $params['name'];
        $customer = isset($params['customer']) ? $params['customer'] : '';
        $number = isset($params['number'])  ? $params['number'] : '';
        $approverId = $params['approver'];        
        foreach($costs as $cost){            
            $cost = $this->get('pp_util.handler')->deserialize(json_encode($cost), 'AppBundle\Entity\Cost');
            $em->merge($cost);
        }        
        
        if ($params['isNewApprover'] == true) {
            $approver = $params['approver'];
            $firstName = $approver['firstName'];
            $lastName = $approver['lastName'];
            $email = $approver['email'];

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return new JsonResponse([
                    'success' => false,
                    'message' => "Invalid email format"
                ]);
            }

            $existingUser = $this->getDoctrine()
                    ->getRepository('AppBundle:User')
                    ->findOneBy(['email' => $email]);

            if (!$existingUser) {
                $userManager = $this->get('fos_user.user_manager');

                $user = $userManager->createUser();
                $user->setEmail($email)
                        ->setPlainPassword('secretpassword')
                        ->setEnabled(true)
                        ->setFirstName($firstName)
                        ->setLastName($lastName);

                $userManager->updateUser($user);
            } else {
                $user = $existingUser;
            }

            $employee = $this->get('pp_employee.handler')->createEmployee($user, $project->getCompany(), $this->getUser(), ['approver']);
            $approverId = $employee->getId();
        }
        
        $approver = $this->getDoctrine()
                ->getRepository('AppBundle:Employee')
                ->find($approverId);
                
        $project = $this->getDoctrine()
                ->getRepository('AppBundle:Project')
                ->edit($id,$customer,$name,$number,$approver);        
        //project = new Project();
        // $project->setName($name);
        // $project->setNumber($number);
        // $project->setApprover($approver);        

        $em->flush();

        $json = $this->get('pp_util.handler')->serialize($project);

        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @Route("/api/project/{id}", name="apiProjectDelete")
     * @Method("DELETE")
     */
    public function deleteAction($id) {
        $deleted = $this->getDoctrine()
            ->getRepository('AppBundle:Project')
            ->delete($id);
        if (is_null($deleted)) {
            throw $this->createNotFoundException(
                    sprintf(
                            'No project found with id %s', $id
                    )
            );
        }

        return new Response('Disabled Project ' . $id, 204);
    }

    /**
     * @Route("/api/company/{id}/projects", name="apiCompanyProjectList")
     * @Method("GET")
     */
    public function companyListAction($id, Request $request) {
        $company = $this->get('pp_util.handler')->getCompany($id);

        $activeProjects = $this->getDoctrine()
                ->getRepository('AppBundle:Project')
                ->findAllActiveByCompany($company);

        $json = $this->get('pp_util.handler')->serialize(['projects' => $activeProjects, 'status' => 'success']);

        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @Route("/api/download/budgetTemplate", name="apiDownloadBudgetTemplate")
     * @Method("GET")
     */
    public function downloadBudgetTemplateAction(Request $request) {
        $projectName = $request->query->get('projectName');
        if (!$projectName || empty($projectName)) {
            throw $this->createNotFoundException('Missing project name');
        }
        $projectNumber = $request->query->get('projectNumber');
        if (!$projectNumber || empty($projectNumber)) {
            $projectNumber = 'N/A';
            //throw $this->createNotFoundException('Missing project number');
        }
        $projectManager = $request->query->get('projectManager');
        if (!$projectManager || empty($projectManager)) {
            throw $this->createNotFoundException('Missing project manager');
        }

        $pathToTemplate = $this->get('kernel')->getProjectDir() . '/web/template/';
        $fileName = 'budget_template.xlsx';
        $temp = "temp/";
        $editedFileName = 'edited_' . uniqid() . '_' . $fileName;
        $editedFilePath = $pathToTemplate . $temp . $editedFileName;

        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject($pathToTemplate . $fileName);
        $phpExcelObject->setActiveSheetIndex(0);
        $phpExcelObject->getActiveSheet()
                ->setCellValue('C2', $projectName)
                ->setCellValue('C3', $projectNumber)
                ->setCellValue('C4', $projectManager);

        // Left align number
        $leftAlignmentStyle = array(
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            ),
        );
        $phpExcelObject->getActiveSheet()->getStyle('C2')->applyFromArray($leftAlignmentStyle);

        $objWriter = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel2007');
        $objWriter->save($editedFilePath);

        $response = new BinaryFileResponse($editedFilePath);

        $mimeTypeGuesser = new FileinfoMimeTypeGuesser();

        if ($mimeTypeGuesser->isSupported()) {
            // Guess the mimetype of the file according to the extension of the file
            $response->headers->set('Content-Type', $mimeTypeGuesser->guess($editedFilePath));
        } else {
            // Set the mimetype of the file manually, in this case for a text file is text/plain
            $response->headers->set('Content-Type', 'text/plain');
        }

        $response->setContentDisposition(
                ResponseHeaderBag::DISPOSITION_ATTACHMENT, $editedFileName
        );

        return $response->deleteFileAfterSend(true);
    }

    /**
     * @Route("/api/company/{id}/customerJobs", name="apiCustomerJobs")
     * @Method("GET")
     */
    public function getCustomerJobsAction($id) {
        $company = $this->get('pp_util.handler')->getCompany($id);

        $customerJobs = $company->getArchivedCustomerJobs();
        $r = $this->get('pp_util.handler')->serialize($customerJobs);

        return new JsonResponse($r, 200, [], true);
    }


    /**
     * @Route("/api/company/{id}/customerJob", name="apiCustomerJob")
     * @Method("POST")
     */
    public function newCustomerJobAction($id, Request $request)
    {
        $company = $this->get('pp_util.handler')->getCompany($id);
        $params = $this->getRequest();
        $name = $params['name'];                
        $customerJob = $this->getDoctrine()
            ->getRepository('AppBundle:ArchivedCustomerJob')
            ->findOneBy(['company' => $company,'name' => $name]);
        $isNewcustomerJob = false;

        if(empty($customerJob)){
            $customerJob = $this->getDoctrine()
            ->getRepository('AppBundle:ArchivedCustomerJob')
            ->add($company, $name);
            $isNewcustomerJob = true;
        }            
        
        $json = $this->get('pp_util.handler')->serialize(['customerJob' => $customerJob, 'isNewcustomerJob' => $isNewcustomerJob]);
        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @Route("/api/projects/import/budget", name="apiImportBudget")
     * @Method("POST")
     */
    public function importBudgetAction(Request $request) {
        $projectId = $request->request->get('projectId');
        $project = $this->getDoctrine()
                ->getRepository('AppBundle:Project')
                ->find($projectId);
        if (!$project) {
            throw $this->createNotFoundException(
                    sprintf(
                            'No project found with id %s', $projectId
                    )
            );
        }

        $company = $project->getCompany();

        $budgetFile = $request->files->get('budgetFile');
        if (!$budgetFile) {
            throw $this->createNotFoundException('Missing budget file');
        }

        $pathToTemplate = $this->get('kernel')->getProjectDir() . '/web/template/temp/';
        $fileName = 'uploaded_budget_template_' . uniqid() . '.xlsx';
        $filePath = $pathToTemplate . $fileName;

        $budgetFile->move($pathToTemplate, $fileName);
        try {


            if (file_exists($filePath)) {
                $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject($filePath);
                $phpExcelObject->setActiveSheetIndex(0);

                $entrySheet = $phpExcelObject->getActiveSheet();
                $em = $this->getDoctrine()->getManager();
                
                //Checker
                $checkerValue = $entrySheet->getCell('B' . 7)->getValue();
                
                if($checkerValue != '*Item or Account') {
                     return new JsonResponse(['success' => false, 'message' => 'Your file did not import for some reason. Please click support@projectprohub.com to send us an email. Attach the file you attempted to upload with an explanation of what steps you took prior to the error.']);
                }
                        
                foreach ($entrySheet->getRowIterator(8) as $row) {
                    $index = $row->getRowIndex();
                    $costCode = $entrySheet->getCell('B' . $index)->getValue();
                    $expenseType = $entrySheet->getCell('C' . $index)->getValue();
                    $description = $entrySheet->getCell('D' . $index)->getValue();
                    $budgetAmount = $entrySheet->getCell('E' . $index)->getValue();

                    if (!empty($costCode)) {
                        if (empty($budgetAmount)) {
                            $budgetAmount = 0;
                        }
                        if (empty($expenseType)) {
                            $expenseType = '';
                        }
                        if (empty($description)) {
                            $description = '';
                        }
                        $cost = new Cost();
                        $cost->setCodeNumber($costCode)
                                ->setExpenseType($expenseType)
                                ->setDescription($description)
                                ->setBudgetAmount($budgetAmount)
                                ->setProject($project);

                        $det = $this->getDoctrine()
                                ->getRepository('AppBundle:DisabledExpenseType')
                                ->findOneBy(['company' => $company, 'name' => $expenseType]);

                        if (isset($det)) {
                            $cost->setEnabled(false);
                        }

                        $em->persist($cost);
                    } else {
                        if ($index == 8) {
                            return new JsonResponse(
                                    [
                                'success' => false,
                                'message' => 'Oops! There was no data to import. Please check that you have at least 1 entry in the Description column.',
                                    ]
                            );
                        }
                    }
                }
                //err
                $em->flush();

                unlink($filePath);

                $json = $this->get('pp_util.handler')->serialize(['costs' => $project->getCosts()]);

                //return new JsonResponse($json, 200, [], true);
                return new JsonResponse(['success' => true, 'message' => 'Import Success!']);
            }
        } catch (\Exception $ex) {
            return new JsonResponse(['success' => false, 'message' => 'Your file did not import for some reason. Please click support@projectprohub.com to send us an email. Attach the file you attempted to upload with an explanation of what steps you took prior to the error.']);
        }

        return new JsonResponse(['success' => false, 'message' => 'Your file did not import for some reason. Please click support@projectprohub.com to send us an email. Attach the file you attempted to upload with an explanation of what steps you took prior to the error.']);
    }

    /**
     * @param $id
     * @return Project|null|object
     */
    private function getProject($id) {
        $project = $this->getDoctrine()
                ->getRepository('AppBundle:Project')
                ->find($id);

        if (!$project) {
            throw $this->createNotFoundException(
                    sprintf(
                            'No project found with id %s', $id
                    )
            );
        }

        return $project;
    }

    private function getRequest() {
        $params = array();
        $content = $this->container->get('request_stack')->getCurrentRequest()->getContent();

        if (!empty($content)) {
            $params = json_decode($content, true); // 2nd param to get as array
        }

        return $params;
    }

}
