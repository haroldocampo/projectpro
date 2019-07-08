<?php
/**
 * Created by PhpStorm.
 * User: marksegalle
 * Date: 11/06/2018
 * Time: 4:08 PM
 */

namespace AppBundle\Repository;


use AppBundle\Entity\PurchaseItem;
use Doctrine\ORM\EntityRepository;

class PurchaseItemRepository extends EntityRepository
{

    /**
     * @param $amount
     * @param $cost
     * @param $tax
     * @param $taxedAmount
     * @param $purchase
     * @return PurchaseItem
     */
    public function create($amount, $cost, $tax, $taxedAmount, $memo = null, $purchase) {
        $em = $this->getEntityManager();

        $purchaseItem = new PurchaseItem();

        $purchaseItem->setAmount($amount)
            ->setCost($cost)
            ->setTax($tax)
            ->setMemo($memo)
            ->setTaxedAmount($taxedAmount)
            ->setPurchase($purchase);

        $em->persist($purchaseItem);
        $em->flush();

        return $purchaseItem;
    }
    public function delete($purchaseItemId){
        $purchase = $this->find($purchaseItemId);
        if (!$purchase) 
            return null;

        $em = $this->getEntityManager();
        $qbExceptions = $purchase->getQbExceptions();

        foreach($qbExceptions as $qe){
            $em->remove($qe);
        }

        $em->remove($purchase);
        $em->flush();
        return true;
    }
    public function associateClass($purchaseId, $classId){
        $purchase = $this->find($purchaseId);

        $purchaseClass = $this->getEntityManager()
            ->getRepository('AppBundle:PurchaseClass')
            ->find($classId);

        if(!$purchase){
            $purchase->setPurchaseClass(null);
            return null;
        }        
            
        $em = $this->getEntityManager();        
        $purchase->setPurchaseClass($purchaseClass);

        $em->flush();
        return $purchase;
    }

}