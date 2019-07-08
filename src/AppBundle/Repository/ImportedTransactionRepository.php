<?php
namespace AppBundle\Repository;

use AppBundle\Entity\ImportedTransaction;
use Doctrine\ORM\EntityRepository;

class ImportedTransactionRepository extends EntityRepository
{    
    public function create($dateTime, $company, $description, $accountNumber, $floatAmount)
    {
        $em = $this->getEntityManager();
        // Query duplicate imported transactions
        $dupeTransaction = $this->findBy(['company' => $company, 'accountNumber' => $accountNumber, 'description' => $description, 'date' => $dateTime]);
        //->findBy(['company' => $company, 'accountNumber' => $accountNumber, 'description' => $description, 'amount' => $amount, 'date' => $dateTime, 'matchedPurchase' => null]);

        
        $importedTransaction = new ImportedTransaction();
        $importedTransaction->setDate($dateTime)
                ->setCompany($company)
                ->setDescription($description)
                ->setAccountNumber($accountNumber)
                ->setAmount($floatAmount);

        if ($dupeTransaction) {
            foreach ($dupeTransaction as $dp) {
                if ((string)$dp->getAmount() == $floatAmount) {
                    $hasDuplicates = true;
                    $importedTransaction->setIsDuplicate(true);
                }
            }
        }
        $em->persist($importedTransaction);
        $em->flush();
        return $importedTransaction;
    }  
    
    public function delete($importedTransactionId)
    {
        $em = $this->getEntityManager();

        $importedTransaction = $this->find($importedTransactionId);

        if(!$importedTransaction)
            return null;
        

        $purchase = $importedTransaction->getMatchedPurchase();

        if (isset($purchase)) {
            $purchase->setDateExported(null)
                    ->setMatchedImportedTransaction(null);
            $importedTransaction->setMatchedPurchase(null);
        }

        $em->remove($importedTransaction);
        $em->flush();
        return true;
    }
    public function deleteDuplicates($company)
    {
        $em = $this->getEntityManager();
        $importedTransactions = $this->findBy(['company' => $company, 'isDuplicate' => true]);

        foreach ($importedTransactions as $importedTransaction) {
            if(!$importedTransaction)
                return null;
            

            $purchase = $importedTransaction->getMatchedPurchase();

            if (isset($purchase)) {
                $purchase->setDateExported(null)
                        ->setMatchedImportedTransaction(null);
                $importedTransaction->setMatchedPurchase(null);
            }

            $em->remove($importedTransaction);
        }

        $em->flush();
        return true;
    }
    public function getMatchedTransactions($company, $totalAmount) {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('transaction')
            ->from('AppBundle:ImportedTransaction', 'transaction')
            ->where('transaction.company = :company')
            ->setParameter('company', $company)
            ->andWhere('transaction.matchedPurchase IS NULL')
            ->andWhere($qb->expr()->eq($qb->expr()->abs('transaction.amount'),abs($totalAmount) ) );
        
        return $qb->getQuery()->getResult();
    }    
    
    
}