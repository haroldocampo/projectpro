<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\QbException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use \SimpleXMLElement;
use AppBundle\Entity\Employee;
use AppBundle\Entity\Purchase;
class QbExceptionController extends Controller {

    /**
     * @Route("/api/purchaseItems/{id}/qbException", name="apiQbExceptionNew")
     * @Method("POST")
     */
    public function newAction($id, Request $request) {      
        $params = $this->getRequest();
        $errorCode = $params['errorCode'];
        $errorMessage = $params['errorMessage'];

        $purchaseItem = $this->getDoctrine()
            ->getRepository('AppBundle:PurchaseItem')
            ->find($id);

        if (!$purchaseItem) {
            throw $this->createNotFoundException("Purchase Item not found");
        }

        $qbException = $this->getDoctrine()
            ->getRepository('AppBundle:QbException')
            ->create($errorCode, $errorMessage, $purchaseItem);

        return new JsonResponse("Added QB Exception");
    }

    /**
     * @Route("/api/company/{id}/export/qbExceptions", name="apiExportQbExceptions")
     * @Method("GET")
     */
    public function exportAction($id, Request $request) {
        $type = 'excel';
        $qbExceptions = $this->getDoctrine()
            ->getRepository('AppBundle:QbException')
            ->findByCompany($id);            
        $phpExcelObject = $this->createExportExcel($qbExceptions);

        return $this->exportResponse($phpExcelObject, $type);
    }

    /**
     * @Route("/api/company/{id}/qb/checkqueue", name="apiQbCheckQueue")
     * @Method("GET")
     */
    public function checkQueueAction($id, Request $request) {
        $searchsql = " 
        SELECT * FROM quickbooks_queue where qb_username = 'projectpro_".$id."' and qb_status = 'q' and enqueue_datetime >= (CURRENT_TIMESTAMP - INTERVAL 2 MINUTE);
        ";

        $clearsql = " 
        UPDATE quickbooks_queue SET qb_status = 'h' where qb_username = 'projectpro_".$id."' and qb_status = 'q' and enqueue_datetime >= (CURRENT_TIMESTAMP - INTERVAL 2 MINUTE);
        ";

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($searchsql);
        $stmt->execute();
        $raw = json_encode($stmt->fetchAll());
        $results = json_decode($raw, true);

        if(count($results) >= 1){
            // CLEAR QUEUE
            //$stmt2 = $em->getConnection()->prepare($clearsql);
            //$stmt2->execute();
            return new JsonResponse(true);
        } else {
            return new JsonResponse(false);
        }
    }

    /**
     * @Route("/api/company/{id}/email/qbExceptions", name="apiEmailQbExceptions")
     * @Method("POST")
     */
    public function emailAction($id, Request $request) {
        $params = $this->getRequest();
        $employeeId = $params['employeeId'];
        $purchases = $params['purchases'];
        $employee = $this->getDoctrine()
            ->getRepository('AppBundle:Employee')
            ->find($employeeId);

        $email = $employee->getUser()->getEmail();
        $name = $employee->getUser()->getFirstName();

        $type = 'excel';
        $qbExceptions = $this->getDoctrine()
            ->getRepository('AppBundle:QbException')
            ->findByCompany($id);            
        $phpExcelObject = $this->createExportExcel($qbExceptions);  
        
        $isSuccessful = count($qbExceptions) <= 0;

        //if($isSuccessful){
        $this->markPurchasesImported($purchases);
        //}
        
        return $this->emailErrors($phpExcelObject, $type, $email, $name, $isSuccessful);
    }

    private function markPurchasesImported($purchases){
        foreach($purchases as $pid){
            $this->getDoctrine()
            ->getRepository('AppBundle:Purchase')
            ->markImported($pid);
        }
    }

    /*
    private function markPurchasesImported($purchases, $qbExceptions){
        foreach($purchases as $pid){
            $isSuccessful = true;
            foreach ($qbExceptions as $qe){
                $exceptionPurchaseId = $qe->getPurchaseItem()->getPurchase()->getId();
                if($exceptionPurchaseId == $pid){
                    $isSuccessful = false;
                }
            }

            if(!$isSuccessful){
                continue;
            }

            $this->getDoctrine()
            ->getRepository('AppBundle:Purchase')
            ->markImported($pid);
        }
    }
    */


    /**
     * @param $qbExceptionsForExport
     * @return \PHPExcel
     */
    private function createExportExcel($qbExceptionsForExport) {
        $em = $this->getDoctrine()->getManager();

        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

        // project name, project number,  description, date purchase, payment type, amount
        // purchase items: cost code, expense type

        $phpExcelObject->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Error Message')
                //->setCellValue('A1', 'Error Code')
                ->setCellValue('B1', 'Purchase ID')
                ->setCellValue('C1', 'Project Name')
                ->setCellValue('D1', 'Project Number')
                ->setCellValue('E1', 'Purchase Date')
                ->setCellValue('F1', 'Vendor')
                ->setCellValue('G1', 'QB Transaction type')
                ->setCellValue('H1', 'Cost Code')
                ->setCellValue('I1', 'Expense Type')
                ->setCellValue('J1', 'Description')
                ->setCellValue('K1', 'Class')
                ->setCellValue('L1', 'Sales Tax')
                ->setCellValue('M1', 'Amount')
                ->setCellValue('N1', 'Payment Type');
                //->setCellValue('N1', 'Error Message');

        $headerRowStyle = $phpExcelObject->getActiveSheet()->getStyle('A1:N1');

        $headerRowStyle->getFont()->setBold(true);
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $headerRowStyle->getBorders()->applyFromArray($styleArray); // TODO: Fix non-existent borders

        foreach (range('B', 'N') as $columnId) {
            $phpExcelObject->getActiveSheet()->getColumnDimension($columnId)->setAutoSize(true);
        }

        $index = 2;       
        foreach ($qbExceptionsForExport as $qbException) {
            $purchaseItem = $qbException->getPurchaseItem();
            $purchase = $purchaseItem->getPurchase();
            $project = $purchase->getProject();

            $phpExcelObject->getActiveSheet()->getColumnDimension('A')->setWidth(25);
            $phpExcelObject->getActiveSheet()
                    ->setCellValue('A' . $index, $qbException->getErrorMessage())
                    //->setCellValue('A' . $index, $qbException->getErrorCode())
                    ->setCellValue('B' . $index, date("Y") . '-' . $purchase->getId())
                    ->setCellValue('C' . $index, $project->getName())
                    ->setCellValue('D' . $index, $project->getNumber())
                    ->setCellValue('E' . $index, $purchase->getDateOfPurchase()->format('m/d/Y'))
                    ->setCellValue('F' . $index, !is_null($purchase->getVendor()) ? $purchase->getVendor()->getName() : ' ')
                    ->setCellValue('G' . $index,!is_null($purchase->getPaymentType()->getTransactionType()) ? $purchase->getPaymentType()->getTransactionType()->getName() : ' ') // QB TRANSACTION TYPE
                    ->setCellValue('H' . $index, $purchaseItem->getCost()->getCodeNumber())
                    ->setCellValue('I' . $index, $purchaseItem->getCost()->getExpenseType())
                    ->setCellValue('J' . $index, $purchaseItem->getCost()->getDescription())
                    ->setCellValue('K' . $index, !is_null($purchaseItem->getPurchaseClass()) ? $purchaseItem->getPurchaseClass()->getName() : ' ')
                    ->setCellValue('L' . $index, '$' . $purchase->getSalesTax())
                    ->setCellValue('M' . $index, '$' . ($purchase->getIsOverrideSalesTax() ? $purchaseItem->getAmount() : $purchaseItem->getTaxedAmount()))
                    ->setCellValue('N' . $index, $purchase->getPaymentType()->getName()); // Sales Tax Override
                    //->setCellValue('N' . $index, $qbException->getErrorMessage()); // Error Message

            $index++;
            $qbException->setIsExported(true);
        }

        $em->flush();

        return $phpExcelObject;
    }


    /**
     * @param \PHPExcel $phpExcelObject
     * @param $type
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    private function exportResponse(\PHPExcel $phpExcelObject, $type) {
        if ($type == 'excel') {
            $type = 'Excel5';
            $fileName = 'export.xls';
        } elseif ($type == 'csv') {
            $type = 'CSV';
            $fileName = 'export.csv';
        } else {
            throw $this->createNotFoundException('Export type not found');
        }

        // create the writer
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, $type);
        // create the response
        $response = $this->get('phpexcel')->createStreamedResponse($writer);

        $dispositionHeader = $response->headers->makeDisposition(
                ResponseHeaderBag::DISPOSITION_ATTACHMENT, $fileName
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;
    }

    private function emailErrors(\PHPExcel $phpExcelObject, $type, $email, $name, $isSuccessful){
        if ($type == 'excel') {
            $type = 'Excel5';
            $fileName = 'export';
        }
        // create the writer
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, $type);        
        //$fileName = tempnam(sys_get_temp_dir(), $fileName);
        $fileName = 'QBExceptionsReport';
        $fileName .= '.xls';
        
        $writer->save($fileName);

        $attachment = \Swift_Attachment::fromPath($fileName);
        
        $message = (new \Swift_Message("QB Import Results"))
                    ->setFrom("accounting@projectprohub.com")
                    ->setTo($email)
                    ->setBody(
                            $this->renderView(
                                    'email/qb_error.html.twig', [
                                'name' => $name,
                                'isSuccessful' => $isSuccessful
                                    ]
                            ), 'text/html'
                    )
                    ->attach($attachment);

            $this->get('mailer')->send($message);

            return new JsonResponse(
                    [
                        'status' => 'success',
                        'message' => 'Please notify him/her to look for an email from fieldpurchases@projectprohub.com',
                    ]
            );
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
