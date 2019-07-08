<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Vendor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Employee;

class VendorController extends Controller
{

    /**
     * @Route("/api/company/{id}/vendors", name="apiVendorNew")
     * @Method("POST")
     */
    public function newAction($id, Request $request)
    {
        $company = $this->get('pp_util.handler')->getCompany($id);
        $params = $this->getRequest();
        $name = trim($params['name']);                
        $vendor = $this->getDoctrine()
            ->getRepository('AppBundle:Vendor')
            ->findOneBy(['company' => $company, 'name' => $name, 'mergeId' => null]);
        $isNewVendor = false;

        if (empty($vendor)) {
            $vendor = $this->getDoctrine()
                ->getRepository('AppBundle:Vendor')
                ->create($company, $name);
            $isNewVendor = true;

            $purchaserUser = $this->getDoctrine()
                ->getRepository('AppBundle:Employee')
                ->find($params['purchaser'])
                ->getUser();

            $admins = $this->getDoctrine()
                ->getRepository('AppBundle:Employee')
                ->findByCompanyRole($company, 'ROLE_ADMIN');
            foreach ($admins as $admin) {
                if (!$admin->getEnabled()) { // Do not send an email if employee is not enabled
                    continue;
                }
                $message = (new \Swift_Message("A new Vendor has been added to ProjectPro"))
                // ->setFrom("fieldpurchases@projectprohub.com")
                    ->setFrom("projectpro.info@gmail.com")
                    ->setTo($admin->getUser()->getEmail())
                    ->setBody(
                        $this->renderView(
                            'email/new_vendor.html.twig',
                            [
                                'purchaserFirstName' => $purchaserUser->getFirstName(),
                                'purchaserLastName' => $purchaserUser->getLastName(),
                                'adminFirstName' => $admin->getUser()->getFirstName(),
                                'adminLastName' => $admin->getUser()->getLastName(),
                                'vendorName' => $vendor->getName()
                            ]
                        ),
                        'text/html'
                    );

                if (isset($params['sendMail'])) {
                    $this->get('mailer')->send($message);
                }
            }
        }

        $json = $this->get('pp_util.handler')->serialize(['vendor' => $vendor, 'isNewVendor' => $isNewVendor]);
        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @Route("/api/company/{id}/vendors", name="apiCompanyVendorList")
     * @Method("GET")
     */
    public function vendorListAction($id, Request $request)
    {
        $company = $this->get('pp_util.handler')->getCompany($id);

        if (!$company) {
            throw $this->createNotFoundException(
                sprintf(
                    'No company found with id %s',
                    $id
                )
            );
        }

        $vendors = $this->getDoctrine()
            ->getRepository('AppBundle:Vendor')
            ->findAllUnmergedByCompany($company);

        $json = $this->get('pp_util.handler')->serialize(['vendors' => $vendors]);

        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @param $id
     * @return JsonResponse
     *
     * @Route("/api/vendors/{id}", name="apiVendorDelete")
     * @Method("DELETE")
     */
    public function deleteAction($id)
    {
        $deleted = $this->getDoctrine()
            ->getRepository('AppBundle:Vendor')
            ->delete($id);
        if (is_null($deleted)) {
            throw $this->createNotFoundException(
                sprintf(
                    'No vendor found with id %s',
                    $id
                )
            );
        }
        if ($deleted) {
            return new JsonResponse(true);
        }
        return new JsonResponse(false);
    }

    /**
     * @Route("/api/vendors/{id}", name="apiVendorUpdate")
     * @Method({"PUT", "PATCH"})
     */
    public function updateAction($id, Request $request)
    {
        $data = $request->getContent();
        $params = json_decode($data, true);
        $name = $params['name'];
        $vendor = $this->getDoctrine()
            ->getRepository('AppBundle:Vendor')
            ->find($id);

        if (!$vendor) {
            throw $this->createNotFoundException(
                sprintf(
                    'No vendor found with id %s',
                    $id
                )
            );
        }
        $updated = $this->getDoctrine()
            ->getRepository('AppBundle:Vendor')
            ->isUniqueName($id, $name);
        if ($updated == 'unique') {
            $vendor = $this->getDoctrine()
                ->getRepository('AppBundle:Vendor')
                ->editName($id, $name);
        }



        $json = $this->get('pp_util.handler')->serialize(['updated' => $updated]);
        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @Route("/api/vendors/{id}", name="apiVendorMerge")
     * @Method("POST")
     */
    public function mergeAction($id, Request $request)
    {
        $data = $request->getContent();
        $params = json_decode($data, true);
        $mergeId = $params['mergeId'];
        $oldVendor = $this->getDoctrine()
            ->getRepository('AppBundle:Vendor')
            ->find($id);


        $purchases = $oldVendor->getPurchases();
        $mergedVendor = $this->getDoctrine()
            ->getRepository('AppBundle:Vendor')
            ->merge($id, $mergeId);
        $em = $this->getDoctrine()->getManager();
        foreach ($purchases as $purchase) {
            $purchase->setVendor($mergedVendor);
            $em->persist($purchase);
        }
        $em->flush();


        return new JsonResponse(['success' => true]);
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