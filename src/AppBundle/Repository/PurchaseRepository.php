<?php
/**
 * Created by PhpStorm.
 * User: marksegalle
 * Date: 11/06/2018
 * Time: 3:37 PM
 */

namespace AppBundle\Repository;


use AppBundle\Entity\Purchase;
use Doctrine\ORM\EntityRepository;

class PurchaseRepository extends EntityRepository
{

    public function create($project, $status, $salesTax, $purchaser, $paymentType, $amount, $purchaseImage, $purchaseDate, $vendor) {
        $em = $this->getEntityManager();
        $purchase = new Purchase();
        $purchase->setProject($project)
            ->setStatus($status)
            ->setSalesTax($salesTax)
            ->setVendor($vendor)
            ->setPurchaser($purchaser)
            ->setPaymentType($paymentType)
            ->setTotalAmount($amount)
            ->setImageFile($purchaseImage);
        
        if ($purchaseDate) {
            $date = \DateTime::createFromFormat('m/d/Y', $purchaseDate);
            if ($date) {
                $purchase->setDateOfPurchase($date);
            }
        }

        $em->persist($purchase);
        $em->flush();
        return $purchase;
    }
    public function edit($purchaseId, $project, $paymentType, $totalAmount, $dateOfPurchase, $qbImport,$vendor){
        $purchase = $this->find($purchaseId);
        if(!$purchase)        
            return null;
        $em = $this->getEntityManager();        
        $purchase->setProject($project)
        ->setPaymentType($paymentType)
        ->setTotalAmount($totalAmount)        
        ->setDateOfPurchase(new \DateTime($dateOfPurchase))
        ->setVendor($vendor)
        ->setQbImport($qbImport);        
        $em->persist($purchase);
        $em->flush();
        return $purchase;
    }

    public function findAllUnapprovedByEmployee($employeeId){
        $qb = $this->_em->createQueryBuilder();
        $qb->select('p')
            ->from('AppBundle:Purchase', 'p')
            ->innerJoin('p.project','proj')
            ->innerJoin('proj.approver','approver')
            ->where("approver.id = :approver_id and p.status = 'STATUS_NOT_APPROVED'")                    
            ->setParameter('approver_id', $employeeId);

        return $qb->getQuery()->getResult();
    }
    public function approve($purchaseId, $employee){
        $em = $this->getEntityManager();
        $purchase = $this->find($purchaseId);
        if(!$purchase)
            return null;
        $purchase->setStatus(Purchase::$STATUS_APPROVED)
            ->setDateApproved(new \DateTime())
            ->setApprover($employee);
        
        $em->flush();
        return $purchase;
    }

    public function markImported($purchaseId){
        $em = $this->getEntityManager();
        $purchase = $this->find($purchaseId);
        if(!$purchase)
            return null;
        $purchase->setDateImported(new \DateTime())
        ->setDateExported(new \DateTime());
        
        $em->flush();
        return $purchase;
    }

    public function decline($purchaseId, $employee, $comment){
        $em = $this->getEntityManager();
        $purchase = $this->find($purchaseId);           
        if(!$purchase)
            return null;
        $purchase->setStatus(Purchase::$STATUS_DECLINED)
                ->setDateDeclined(new \DateTime())
                ->setComments($comment)
                ->setDecliner($employee);
        
        $em->flush();
        return $purchase;
    }
    public function toggleImport($purchaseId, $qbImport){
        $em = $this->getEntityManager();
        $purchase = $this->find($purchaseId);           
        if(!$purchase)
            return null;
        $purchase->setQbImport($qbImport);        
        $em->flush();
        return $purchase;
    }
    public function delete($purchaseId){
        $em = $this->getEntityManager();

        $purchase = $this->find($purchaseId);

        if (!$purchase) 
            return null;

        $items = $purchase->getPurchaseItems();

        foreach ($items as $pi) {
            $em->remove($pi);
        }

        $em->remove($purchase);
        $em->flush();
        return true;
    }

}