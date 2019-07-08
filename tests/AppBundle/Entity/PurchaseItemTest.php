<?php
namespace Tests\AppBundle\Entity;

use AppBundle\Entity\PurchaseItem;
use PHPUnit\Framework\TestCase;
class PurchaseItemTest extends TestCase
{        
    public function testSetAmount()
    {        
        $amount = "1234";
        $purchaseItem = new PurchaseItem;
        $purchaseItem->setAmount($amount);        
        $this->assertEquals($amount,$purchaseItem->getAmount());
    }      
    public function testSetDateCreated()
    {
        $date = new \DateTime;
        $purchaseItem = new PurchaseItem;
        $purchaseItem->setDateCreated($date);
        $this->assertEquals($date,$purchaseItem->getDateCreated());
    }
    public function testSetCost()
    {       
        $cost = new \AppBundle\Entity\Cost;
        $purchaseItem = new PurchaseItem;
        $purchaseItem->setCost($cost);        
        $this->assertEquals($cost,$purchaseItem->getCost());
    }
    public function testSetPurchase()
    {        
        $purchase = new \AppBundle\Entity\Purchase;
        $purchaseItem = new PurchaseItem;
        $purchaseItem->setPurchase($purchase);        
        $this->assertEquals($purchase,$purchaseItem->getPurchase());
    }
    public function testSetTax()
    {        
        $tax = "1234";
        $purchaseItem = new PurchaseItem;
        $purchaseItem->setTax($tax);        
        $this->assertEquals($tax,$purchaseItem->getTax());
    }      
    public function testSetTaxedAmount()
    {        
        $taxedAmount = "1234";
        $purchaseItem = new PurchaseItem;
        $purchaseItem->setTaxedAmount($taxedAmount);        
        $this->assertEquals($taxedAmount,$purchaseItem->getTaxedAmount());
    }      
}