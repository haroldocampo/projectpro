<?php
namespace AppBundle\Repository;

use AppBundle\Entity\PaymentType;
use AppBundle\Entity\TransactionType;
use Doctrine\ORM\EntityRepository;

class PaymentTypeRepository extends EntityRepository
{    
    public function create($company,$name)
    {
        $em = $this->getEntityManager();
        $dname = "DONT IMPORT TO QB";
        // This should always be the default transaction type, activate this as soon as possible
        $defaultTransactionType = $this->getEntityManager()
        ->getRepository('AppBundle:TransactionType')
           ->findBy(['name' => $dname]);
        if(!$defaultTransactionType){
            // $defaultTransactionType = $this->getEntityManager()
            //     ->getRepository('AppBundle:TransactionType')
            //     ->create($company, $name);
            $defaultTransactionType = new TransactionType;
            $defaultTransactionType->setName($dname);
            $em->persist($defaultTransactionType);                
        } else {
            $defaultTransactionType = $defaultTransactionType[0];
        }
        

        $paymentType = new PaymentType();
        $paymentType->setCompany($company)
                ->setName($name)
                ->setTransactionType($defaultTransactionType);

        $em->persist($paymentType);
        $em->flush();
        return $paymentType;
    }  

    public function associateTransactionType($id, $transactionTypeId)
    {
        $em = $this->getEntityManager();

        $paymentType = $this->getEntityManager()
            ->getRepository('AppBundle:PaymentType')
            ->find($id);

        $transactionType = $this->getEntityManager()
            ->getRepository('AppBundle:TransactionType')
            ->find($transactionTypeId);
            
        $paymentType->setTransactionType($transactionType);

        $em->flush();
        return $paymentType;
    }
    
    public function delete($paymentTypeId)
    {
        $em = $this->getEntityManager();

        $paymentType = $this->find($paymentTypeId);
        if(!$paymentType)
            return null;        
        //$em->remove($paymentType);
        $paymentType->setEnabled(false);
        $em->flush();
        return true;
    }
    
    
}