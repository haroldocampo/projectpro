<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\PaymentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PurchaseClassController extends Controller {

    /**
     * @Route("/api/company/{id}/purchaseClass", name="apiPurchaseClassNew")
     * @Method("POST")
     */
    public function newAction($id, Request $request) { 
        $company = $this->get('pp_util.handler')->getCompany($id);
        $params = $this->getRequest();
        $name = $params['name'];

        if (!$name) {
            throw $this->createNotFoundException("Missing name from request");
        }

        $purchaseClass = $this->getDoctrine()
            ->getRepository('AppBundle:PurchaseClass')
            ->create($company,$name);

        return new JsonResponse("Added Class");
    }

    /**
     * @Route("/api/purchaseclass/{id}", name="apiPurchaseClassDelete")
     * @Method("DELETE")
     */
    public function deleteAction($id) {
        $deleted = $this->getDoctrine()
                ->getRepository('AppBundle:PurchaseClass')
                ->delete($id);
        if (is_null($deleted)) {
            throw $this->createNotFoundException(
                    sprintf(
                            'No purchase class found with id %s', $id
                    )
            );
        }        
        return new Response('Deleted Purchase Class ' . $id, 204);
    }

    /**
     * @Route("/api/company/{id}/purchaseClassList", name="apiPurchaseClassList")
     * @Method("GET")
     */
    public function companyPurchaseClassListAction($id) {
        $company = $this->get('pp_util.handler')->getCompany($id);

        $classes = $this->getDoctrine()
                ->getRepository('AppBundle:PurchaseClass')
                ->findBy(['company' => $company]);

        $result = [];

        $result[] = ['cannotDelete' => false, 'item' => ['name' => '', 'id'=> 0]];
        foreach ($classes as $c) {
            $result[] = ['cannotDelete' => $c->getHasPurchases(), 'item' => $c];
        }

        $json = $this->get('pp_util.handler')->serialize($result);

        return new JsonResponse($json, 200, [], true);
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
