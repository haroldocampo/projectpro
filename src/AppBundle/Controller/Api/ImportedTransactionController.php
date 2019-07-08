<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\ImportedTransaction;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ImportedTransactionController extends Controller {

    /**
     * @Route("/api/company/{id}/import/ccStatement", name="apiImportCCStatement")
     * @Method("POST")
     */
    public function importCCStatementAction($id, Request $request) {
        $company = $this->get('pp_util.handler')->getCompany($id);

        $ccStatementFile = $request->files->get('ccStatementFile');
        if (!$ccStatementFile) {
            throw $this->createNotFoundException('Missing credit card statement file');
        }

        $pathToTemplate = $this->get('kernel')->getProjectDir() . '/web/template/temp/';
        $fileName = 'uploaded_cc_statement_template_' . uniqid() . '.xlsx';
        $filePath = $pathToTemplate . $fileName;

        $ccStatementFile->move($pathToTemplate, $fileName);

        try {
            $hasDuplicates = false;
            if (file_exists($filePath)) {
                $em = $this->getDoctrine()->getManager();

                // clear imported
//            $unMatchedImports = $this->getDoctrine()
//                ->getRepository('AppBundle:ImportedTransaction')
//                ->findBy(['matchedPurchase' => null]);
//            foreach ($unMatchedImports as $import) {
//                $em->remove($import);
//            }
//            $em->flush();

                $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject($filePath);
                $phpExcelObject->setActiveSheetIndex(0);

                $entrySheet = $phpExcelObject->getActiveSheet();

                $importCount = 0;

                // starting 6th row
                foreach ($entrySheet->getRowIterator(6) as $row) {
                    $index = $row->getRowIndex();

                    $dateCell = $entrySheet->getCell('A' . $index);
                    $date = $dateCell->getValue();
                    $description = $entrySheet->getCell('B' . $index)->getValue();
                    $accountNumber = $entrySheet->getCell('C' . $index)->getValue();
                    $amount = $entrySheet->getCell('D' . $index)->getValue();

                    if (!isset($date)) {
                        continue;
                    }

                    if (!empty($date) && !empty($amount)) {
                        $result = \PHPExcel_Style_NumberFormat::toFormattedString(
                                        $date, \PHPExcel_Style_NumberFormat::FORMAT_DATE_DATETIME
                        );
                        // Changed today for proj-505
                        // $amount = abs($amount);

                        //var_dump($result);

                        $dateTime = \DateTime::createFromFormat("d/m/y H:i", $result);
                        if (!$dateTime) {
                            $dateTime = \DateTime::createFromFormat("m/d/Y", $result);
                        }

//                        $dateSliced = explode("/", $result);
//
//                        if(strlen($dateSliced[2]) == 2){
//                            $dateTime = \DateTime::createFromFormat("d/m/y", $result);
//                        } else {
//                            $dateTime = \DateTime::createFromFormat("m/d/Y", $result);
//                        }
//                    $dateTime = \DateTime::createFromFormat("m-d-Y", $result);
//                    if (!$dateTime) {
//                        $dateTime = \DateTime::createFromFormat("m/d/Y", $result);
//                    }
//                    if (!$dateTime) {
//                        $dateTime = \DateTime::createFromFormat("m/d/y", $result);
//                    }
//                    if(!$dateTime) {
//                        $dateTime = \DateTime::createFromFormat("d/m/y", $result);
//                    }
                        $floatAmount = $amount;
                        $amount = number_format($amount, 2);
                        // Query duplicate imported transactions
                        $dupeTransaction = $this->getDoctrine()
                                ->getRepository('AppBundle:ImportedTransaction') // AMOUNT
                                ->findBy(['company' => $company, 'accountNumber' => $accountNumber, 'description' => $description, 'date' => $dateTime]);                       
                        if ($dupeTransaction) {
                            foreach ($dupeTransaction as $dp) {
                                if ((string)$dp->getAmount() == $amount)
                                    $hasDuplicates = true;                                                                    
                            }
                        }

                        $importedTransaction = $em
                        ->getRepository('AppBundle:ImportedTransaction')
                        ->create($dateTime, $company, $description, $accountNumber, $floatAmount);

                        // $em->persist($importedTransaction);

                        $importCount += 1;
                    }
                }

                $em->flush();

                unlink($filePath);

                return new JsonResponse([
                    'success' => true,
                    'hasDuplicates' => $hasDuplicates,
                    'importCount' => $importCount
                ]);
            }
        } catch (\Exception $e) {
            return new JsonResponse([
                'success' => false,
                'hasDuplicates' => false,
                'message' => 'Your file did not import for some reason. Please click support@projectprohub.com to send us an email. Attach the file you attempted to upload with an explanation of what steps you took prior to the error.'                
            ]);
        }

        return new JsonResponse([
            'success' => false,
            'hasDuplicates' => false,
            'message' => 'cannot read file'
        ]);
    }

    /**
     * @Route("/api/company/{id}/importedTransactions/deleteduplicates", name="apiImportedTransactionDeleteDuplicates")
     * @Method("DELETE")
     */
    public function deleteDuplicatesAction($id) {
        $company = $this->get('pp_util.handler')->getCompany($id);

        $em = $this->getDoctrine()->getManager();
        $deleted = $em->getRepository('AppBundle:ImportedTransaction')
            ->deleteDuplicates($company);
        if (is_null($deleted)) {
                throw $this->createNotFoundException(
                        sprintf(
                                'No transactions found'
                        )
                );
        }
        return new JsonResponse("Deleted imported transaction " . $id);
    }

    /**
     * @Route("/api/importedTransactions/{id}", name="apiImportedTransactionDelete")
     * @Method("DELETE")
     */
    public function deleteAction($id) {
        $deleted = $this->getDoctrine()->getRepository('AppBundle:ImportedTransaction')
            ->delete($id);
        if (is_null($deleted)) {
                throw $this->createNotFoundException(
                        sprintf(
                                'No transaction found with id %s', $id
                        )
                );
            }
        return new JsonResponse("Deleted imported transaction dd " . $id);
    }

}
