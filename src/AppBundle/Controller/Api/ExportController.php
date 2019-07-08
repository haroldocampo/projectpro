<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Purchase;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class ExportController extends Controller {

    /**
     * @Route("/api/company/{id}/export/list", name="apiExportCompanyList")
     * @Method("GET")
     */
    public function companyForExportListAction($id) {
        $purchasesForExport = $this->getCompanyPurchaseItemsForExport($id);

        $json = $this->get('pp_util.handler')->serialize($purchasesForExport);

        return new JsonResponse($json, 200, [], true);
    }

    /**
     * @Route("/api/company/{id}/export", name="apiExportCompanyDefault")
     * @Method("GET")
     */
    public function exportAction($id, Request $request) {
        $type = $request->query->get('type');

        $phpExcelObject = $this->createExportExcel($this->getCompanyPurchaseItemsForExport($id));

        return $this->exportResponse($phpExcelObject, $type);
    }

    /**
     * @Route("/api/export/custom", name="apiExportCustom")
     */
    public function customAction(Request $request) {
        $data = $request->getContent();
        $params = json_decode($data, true);

        $purchaseIds = $params['purchaseIds']; // array
        $type = $params['type']; // 'excel' or 'csv'

        $purchaseItemsForExport = [];

        foreach ($purchaseIds as $id) {
            foreach ($this->getPurchase($id)->getPurchaseItems() as $purchaseItem) {
                $purchaseItemsForExport[] = $purchaseItem;
            }
        }

        $phpExcelObject = $this->createExportExcel($purchaseItemsForExport);

        return $this->exportResponse($phpExcelObject, $type);
    }

    /**
     * @Route("/api/export/dashboard", name="apiExportDashboard")
     * @Method("GET")
     */
    public function dashboardAction(Request $request) {
        $companyId = $request->query->get('companyId');
        $company = $this->get('pp_util.handler')->getCompany($companyId);

        $reconciled = $request->query->get('reconciled'); // yes, no, all
        $approved = $request->query->get('approved'); // yes, no, all
        $type = $request->query->get('type'); // excel, csv
        $paymentTypes = $request->query->get('paymentType'); // paymenttypes

        $purchaseItems = $this->getCompanyAllPurchaseItemsForExport($company);

        foreach ($purchaseItems as $key => $purchaseItem) {
            $purchase = $purchaseItem->getPurchase();

            if ($purchase->getDateExported() != null) {
                unset($purchaseItems[$key]);
            }
        }

        foreach ($purchaseItems as $key => $purchaseItem) {
            $purchase = $purchaseItem->getPurchase();

            switch ($approved) {
                case 'yes':
                    if ($purchase->getDateApproved() == null) {
                        unset($purchaseItems[$key]);
                    }
                    break;
                case 'no';
                    if ($purchase->getDateApproved() != null) {
                        unset($purchaseItems[$key]);
                    }
                    break;
            }
        }
        
        if ($paymentTypes) {
            foreach ($purchaseItems as $key => $purchaseItem) {
                $purchase = $purchaseItem->getPurchase();
                $ptId = $purchase->getPaymentType()->getId();
                if (!in_array($ptId, $paymentTypes)) {
                    unset($purchaseItems[$key]);
                }
            }
        }


        foreach ($purchaseItems as $key => $purchaseItem) {

            $purchase = $purchaseItem->getPurchase();
            switch ($reconciled) {
                case 'yes':
                    if ($purchase->getMatchedImportedTransaction() == null) {
                        unset($purchaseItems[$key]);
                    }
                    break;
                case 'no';
                    if ($purchase->getMatchedImportedTransaction() != null) {
                        unset($purchaseItems[$key]);
                    }
                    break;
            }
        }
//        $json = $this->get('pp_util.handler')->serialize([
//            'export' => $purchaseItems
//        ]);
//        return new JsonResponse($json, 200, [], true);
        $phpExcelObject = $this->createExportExcel($purchaseItems);

        return $this->exportResponse($phpExcelObject, $type);
    }

    /**
     * @Route("/api/company/{id}/export/adhoclist", name="apiAdhocExportReviewDashboard")
     * @Method("POST")
     */
    public function adhocExportReviewAction($id, Request $request) {
        $companyId = $id;
        $company = $this->get('pp_util.handler')->getCompany($companyId);
        $params = $this->getRequest();

        $reconciled = $params['reconciled']; // yes, no, all
        $approved = $params['approved']; // yes, no, all
        $type = $params['type']; // excel, csv
        $paymentTypes = $params['paymentType']; // paymenttypes

        $purchaseItems = $this->getCompanyAllPurchaseItemsForExport($company);

        foreach ($purchaseItems as $key => $purchaseItem) {
            $purchase = $purchaseItem->getPurchase();

            if ($purchase->getDateExported() != null) {
                unset($purchaseItems[$key]);
            }
        }

        foreach ($purchaseItems as $key => $purchaseItem) {
            $purchase = $purchaseItem->getPurchase();

            switch ($approved) {
                case 'yes':
                    if ($purchase->getDateApproved() == null) {
                        unset($purchaseItems[$key]);
                    }
                    break;
                case 'no';
                    if ($purchase->getDateApproved() != null) {
                        unset($purchaseItems[$key]);
                    }
                    break;
            }
        }
        
        if ($paymentTypes) {
            foreach ($purchaseItems as $key => $purchaseItem) {
                $purchase = $purchaseItem->getPurchase();
                $ptId = $purchase->getPaymentType()->getId();
                if (!in_array($ptId, $paymentTypes)) {
                    unset($purchaseItems[$key]);
                }
            }
        }


        foreach ($purchaseItems as $key => $purchaseItem) {

            $purchase = $purchaseItem->getPurchase();
            switch ($reconciled) {
                case 'yes':
                    if ($purchase->getMatchedImportedTransaction() == null) {
                        unset($purchaseItems[$key]);
                    }
                    break;
                case 'no';
                    if ($purchase->getMatchedImportedTransaction() != null) {
                        unset($purchaseItems[$key]);
                    }
                    break;
            }
        }

        $json = $this->get('pp_util.handler')->serialize($purchaseItems);
        return new JsonResponse($json, 200, [], true);
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
    
    /**
     * @param \PHPExcel $phpExcelObject
     * @param $type
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    private function exportResponseZip(\PHPExcel $phpExcelObject, $type) {
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

    /**
     * @param $purchaseItemsForExport
     * @return \PHPExcel
     */
    private function createExportExcel($purchaseItemsForExport) {
        $em = $this->getDoctrine()->getManager();

        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

        // project name, project number,  description, date purchase, payment type, amount
        // purchase items: cost code, expense type

        $phpExcelObject->setActiveSheetIndex(0)
                ->setCellValue('A1', 'Purchase ID')
                ->setCellValue('B1', 'Project Name')
                ->setCellValue('C1', 'Project Number')
                ->setCellValue('D1', 'Purchase Date')
                ->setCellValue('E1', 'Vendor')
                ->setCellValue('F1', 'Payment Type')
                ->setCellValue('G1', 'QB Transaction Type')
                ->setCellValue('H1', 'Cost Code')
                ->setCellValue('I1', 'Expense Type')
                ->setCellValue('J1', 'Description')
                ->setCellValue('K1', 'Class')
                ->setCellValue('L1', 'Sales Tax')
                ->setCellValue('M1', 'Amount')
                ->setCellValue('N1', 'Submitted By')
                ->setCellValue('O1', 'Receipt URL')
                ->setCellValue('P1', 'Memo')
                ->setCellValue('Q1', 'Approver')
                ->setCellValue('R1', 'Date Approved');

        $headerRowStyle = $phpExcelObject->getActiveSheet()->getStyle('A1:P1');

        $headerRowStyle->getFont()->setBold(true);
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $headerRowStyle->getBorders()->applyFromArray($styleArray); // TODO: Fix non-existent borders

        foreach (range('A', 'R') as $columnId) {
            $phpExcelObject->getActiveSheet()->getColumnDimension($columnId)->setAutoSize(true);
        }

        $index = 2;
        foreach ($purchaseItemsForExport as $purchaseItem) {
            $purchase = $purchaseItem->getPurchase();
            $project = $purchase->getProject();
            //$purchase = new Purchase();
            $phpExcelObject->getActiveSheet()
                    ->setCellValue('A' . $index, date("Y") . '-' . $purchase->getId())
                    ->setCellValue('B' . $index, $project->getName())
                    ->setCellValue('C' . $index, $project->getNumber())
                    ->setCellValue('D' . $index, $purchase->getDateOfPurchase()->format('m/d/Y'))
                    ->setCellValue('E' . $index, !is_null($purchase->getVendor()) ? $purchase->getVendor()->getName() : ' ') // VENDOR
                    ->setCellValue('F' . $index, $purchase->getPaymentType()->getName())
                    ->setCellValue('G' . $index, !is_null($purchase->getPaymentType()->getTransactionType()) ? $purchase->getPaymentType()->getTransactionType()->getName() : ' ') // QB TRANSACTION TYPE
                    ->setCellValue('H' . $index, $purchaseItem->getCost()->getCodeNumber())
                    ->setCellValue('I' . $index, $purchaseItem->getCost()->getExpenseType())
                    ->setCellValue('J' . $index, $purchaseItem->getCost()->getDescription())
                    ->setCellValue('K' . $index, !is_null($purchaseItem->getPurchaseClass()) ? $purchaseItem->getPurchaseClass()->getName() : ' ') // CLASS
                    ->setCellValue('L' . $index, '$' . $purchase->getSalesTax())
                    ->setCellValue('M' . $index, '$' . ($purchase->getIsOverrideSalesTax() ? $purchaseItem->getAmount() : $purchaseItem->getTaxedAmount())) // Sales Tax Override
                    ->setCellValue('N' . $index, $purchase->getPurchaser()->getUser()->getFirstName(). ' '. $purchase->getPurchaser()->getUser()->getLastName())
                    ->setCellValue('O' . $index, 'https://s3.amazonaws.com/projectpro-live/purchase_images/' . $purchase->getImage() )
                    ->setCellValue('P' . $index, $purchaseItem->getMemo())
                    ->setCellValue('Q' . $index, !is_null($purchase->getApprover()) ? $purchase->getApprover()->getUser()->getFirstName() . ' ' . $purchase->getApprover()->getUser()->getLastName() : ' ')
                    ->setCellValue('R' . $index, !is_null($purchase->getDateApproved()) ? $purchase->getDateApproved()->format('m/d/Y') : ' ');
//                ->getStyle('H' . $index)->getNumberFormat()->setFormatCode‌​("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

            $index++;

            $purchase->setDateExported(new \DateTime());
        }

        $em->flush();

        return $phpExcelObject;
    }

    /**
     * @param $id
     * @return array
     */
    private function getCompanyPurchaseItemsForExport($id) {
        $company = $this->get('pp_util.handler')->getCompany($id);

        $projects = $this->getDoctrine()
                ->getRepository('AppBundle:Project')
                ->findBy(['company' => $company]);

        $purchaseItemsForExport = [];

        foreach ($projects as $project) {
            $purchases = $project->getPurchases();
            foreach ($purchases as $purchase) {
                if ($purchase->getDateExported() == null && $purchase->getMatchedImportedTransaction()) {
                    foreach ($purchase->getPurchaseItems() as $purchaseItem) {
                        $purchaseItemsForExport[] = $purchaseItem;
                    }
                }
            }
        }
        return $purchaseItemsForExport;
    }

    /**
     * @param $id
     * @return array
     */
    private function getCompanyAllPurchaseItemsForExport($id) {
        $company = $this->get('pp_util.handler')->getCompany($id);

        $projects = $this->getDoctrine()
                ->getRepository('AppBundle:Project')
                ->findBy(['company' => $company]);

        $purchaseItemsForExport = [];

        foreach ($projects as $project) {
            $purchases = $project->getPurchases();
            foreach ($purchases as $purchase) {
                //if ($purchase->getDateExported() == null && $purchase->getMatchedImportedTransaction()) {
                foreach ($purchase->getPurchaseItems() as $purchaseItem) {
                    $purchaseItemsForExport[] = $purchaseItem;
                }
                //}
            }
        }
        return $purchaseItemsForExport;
    }

    /**
     * @param $id
     * @return Purchase|null|object
     */
    private function getPurchase($id) {
        $purchase = $this->getDoctrine()
                ->getRepository('AppBundle:Purchase')
                ->find($id);

        if (!$purchase) {
            throw $this->createNotFoundException(
                    sprintf(
                            'No purchase found with %s', $id
                    )
            );
        }

        return $purchase;
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
