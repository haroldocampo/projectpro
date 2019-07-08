<?php

namespace AppBundle\Fixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PurchaseFixtures
 *
 * @author Harold
 */
class PurchaseFixtures extends Fixture {

    public function load(ObjectManager $manager)
    {
        $em = $manager;
        
        $projectId = 12;
        $project = $em
                ->getRepository('AppBundle:Project')
                ->find($projectId);

        $employeeId = 3;
        $employee = $em
                ->getRepository('AppBundle:Employee')
                ->find($employeeId);

        

        // Test Payment Type
        // TODO: proper payment type selection
        $paymentType = $em
                ->getRepository('AppBundle:PaymentType')
                ->find(10);

        $purchase = new \AppBundle\Entity\Purchase();

        $purchase->setProject($project)
                ->setStatus(\AppBundle\Entity\Purchase::$STATUS_NOT_APPROVED)
                ->setPurchaser($employee)
                ->setSalesTax(0)
                ->setTotalAmount(10)
                ->setPaymentType($paymentType)
                ->setReceiptImageUrl("https://expressexpense.com/images/sample-gas-receipt.jpg")
                ->setUpdatedAt(new \DateTime())
                ->setImage('5b023a0959086485796278.jpg');
                

        $em->persist($purchase);
        $em->flush();

        foreach ($project->getCosts() as $cost) {
            if ($cost->isEnabled()) {
                $purchaseItem = new \AppBundle\Entity\PurchaseItem();
                
                $amount = rand(10, 50);
                
                $purchaseItem->setAmount($amount)
                        ->setCost($cost)
                        ->setTaxedAmount($amount)
                        ->setTax(10)
                        ->setPurchase($purchase);
                $em->persist($purchaseItem);
            }
        }
        $em->flush();

        $manager->flush();
    }
    
}
