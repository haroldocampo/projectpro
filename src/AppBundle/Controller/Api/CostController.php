<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Cost;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CostController extends Controller {

    /**
     * @Route("/api/costs", name="apiCostNew")
     * @Method("POST")
     */
    public function newAction(Request $request) {
        $params = $this->getRequest();
        $projectId = $params['projectId'];
        $codeNumber = $params['codeNumber'];

        if(isset($params['expenseType'])){
            $expenseType = $params['expenseType'];
        } else {
            $expenseType = '';
        }
        if(isset($params['description'])){
            $description = $params['description'];
        } else {
            $description = '';
        }
        if(isset($params['budgetAmount'])){
            $budgetAmount = $params['budgetAmount'];
        } else {
            $budgetAmount = 0;
        }

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
        $em = $this->getDoctrine()->getManager();
        $cost = $this->getDoctrine()
            ->getRepository('AppBundle:Cost')
            ->create($project,$codeNumber,$expenseType,$description,$budgetAmount);        

        $json = $this->get('pp_util.handler')->serialize(['cost' => $cost]);
        return new JsonResponse($json, 200, [], true);        
    }

    /**
     * @Route("/api/costs/{id}", name="apiCostUpdate")
     * @Method("PUT")
     */
    public function updateAction($id, Request $request) {
        $params = $this->getRequest();
        $codeNumber = $params['code_number'];

        // Nullable
        if(isset($params['expense_type'])){
            $expenseType = $params['expense_type'];
        } else {
            $expenseType = '';
        }
        if(isset($params['description'])){
            $description = $params['description'];
        } else {
            $description = '';
        }
        if(isset($params['budget_amount'])){
            $budgetAmount = $params['budget_amount'];
        } else {
            $budgetAmount = 0;
        }

        $em = $this->getDoctrine()->getManager();
        $cost = $this->getDoctrine()
            ->getRepository('AppBundle:Cost')
            ->update($id,$codeNumber,$expenseType,$description,$budgetAmount);        

        $json = $this->get('pp_util.handler')->serialize(['cost' => $cost]);
        return new JsonResponse($json, 200, [], true);        
    }

    /**
     * @Route("/api/company/{id}/costs", name="apiCompanyCostList")
     * @Method("GET")
     * 
     * Method is currently not in use.
     */
    // public function companyListAction($id, Request $request) {
    //     $company = $this->getDoctrine()
    //             ->getRepository('AppBundle:Company')
    //             ->find($id);

    //     if (!$company) {
    //         throw $this->createNotFoundException(
    //                 sprintf(
    //                         'No company found with id %s', $id
    //                 )
    //         );
    //     }

    //     $projects = $this->getDoctrine()
    //             ->getRepository('AppBundle:Project')
    //             ->findBy(['company' => $company]);

    //     $resultCosts = array();
    //     foreach ($projects as $project) {
    //         $costs = $project->getCosts();
    //         foreach ($costs as $cost) {
    //             $resultCosts[] = $cost;
    //         }
    //     }
    //     $resultCosts = $this->getDoctrine()
    //         ->getRepository('AppBunle:Project')
    //         ->findByCompany($company);

    //     $json = $this->get('pp_util.handler')->serialize(['costs' => $resultCosts]);

    //     return new JsonResponse($json, 200, [], true);
    // }

    /**
     * @Route("/api/project/{id}/costs", name="apiProjectCostList")
     * @Method("GET")
     */
    public function projectListAction($id, Request $request) {
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

        $costs = $this->getDoctrine()
                ->getRepository('AppBundle:Cost')
                ->findBy(['project' => $project, 'enabled' => true], ['codeNumber' => 'ASC']);

        $json = $this->get('pp_util.handler')->serialize(['costs' => $costs]);

        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @param $id
     * @return JsonResponse
     *
     * @Route("/api/costs/{id}/budget", name="apiCostBudget")
     * @Method("GET")
     */
    public function budgetAction($id) {
        
        $cost = $this->getDoctrine()
            ->getRepository('AppBundle:Cost')
            ->find($id);

        if($cost){
            $budgetAmount = $cost->getBudgetAmount();
            $approvedAmount = 0;
            $purchaseItems = $cost->getPurchaseItems();

            foreach($purchaseItems as $pi){
                if($pi->getPurchase()->getStatus() == 'STATUS_APPROVED'){
                    $approvedAmount += $pi->getAmount();
                }
            }

            return new JsonResponse($approvedAmount);
        }

        return new JsonResponse(false);
    }

    /**
     * @param $id
     * @return JsonResponse
     *
     * @Route("/api/costs/{id}", name="apiCostDelete")
     * @Method("DELETE")
     */
    public function deleteAction($id) {
        
        $deleted = $this->getDoctrine()
            ->getRepository('AppBundle:Cost')
            ->delete($id);
        if (is_null($deleted)) {
                throw $this->createNotFoundException(
                        sprintf(
                                'No cost found with id %s', $id
                        )
                );
        }
        if($deleted)
            return new JsonResponse(true);
        return new JsonResponse(false);
    }

    /**
     * @Route("/api/costs/{id}/toggle", name="apiEnableCost")
     * @Method("POST")
     */
    public function enableAction($id, Request $request) {
        $params = $this->getRequest();        
        $action = $params['action'];

        if ($action == 'enable') {
            $action = true;
        } else {
            $action = false;
        }
        $isAllExpenseTypes = $params['isAllExpenseTypes'];
        $isAllProjects = $params['isAllProjects'];

        $cost = $this->getDoctrine()
        ->getRepository('AppBundle:Cost')
        ->toggleCost($id, $action, $isAllExpenseTypes, $isAllProjects);
        
        if (is_null($cost)) {
            throw $this->createNotFoundException(
                    sprintf(
                            'No cost found with id %s', $costId
                    )
            );
        }

        return new JsonResponse(['success' => true]);
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
