<?php
namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Cost;
use PHPUnit\Framework\TestCase;
class CostTest extends TestCase
{        
    public function testUpdateTimeStamps()
    {
        $cost = new Cost;
        $cost->updatedTimeStamps();
        $this->assertInstanceOf(\DateTime::class,$cost->getDateTimeCreated());
    }     
    public function testSetCodeNumber()
    {
        $cost = new Cost;
        $code_number = "1234";
        $cost->setCodeNumber($code_number);
        $this->assertEquals($code_number,$cost->getCodeNumber());
    }
    public function testSetExpenseType()
    {
        $cost = new Cost;
        $expense = "materials";
        $cost->setExpenseType($expense);
        $this->assertEquals($expense,$cost->getExpenseType());
    }
    public function testSetDescription()
    {
        $cost = new Cost;
        $description = "description";
        $cost->setDescription($description);
        $this->assertEquals($description,$cost->getDescription());
    }
    public function testSetBudgetAmount()
    {
        $cost = new Cost;
        $budget_amount = "budget_amount";
        $cost->setBudgetAmount($budget_amount);
        $this->assertEquals($budget_amount,$cost->getBudgetAmount());
    }
    public function testSetCurrency()
    {
        $cost = new Cost;
        $currency = "usd";
        $cost->setCurrency($currency);
        $this->assertEquals($currency,$cost->getCurrency());
    }
    public function testSetProject()
    {
        $cost = new Cost;
        $project = new \AppBundle\Entity\Project;
        $cost->setProject($project);
        $this->assertEquals($project,$cost->getProject());
    }
    public function testDateTimeCreated()
    {
        $cost = new Cost;
        $project = new \AppBundle\Entity\Project;
        $cost->setProject($project);
        $this->assertEquals($project,$cost->getProject());
    }
    public function testSetEnabledTrue()
    {
        $cost = new Cost;
        $cost->setEnabled(true);
        $this->assertTrue($cost->getEnabled());
    }
    public function testSetEnabledFalse()
    {
        $cost = new Cost;
        $cost->setEnabled(false);
        $this->assertFalse($cost->getEnabled());
    }
    public function testSetHiddenTrue()
    {
        $cost = new Cost;
        $cost->setHidden(true);
        $this->assertTrue($cost->getHidden());
    }
    public function testSetHiddenFalse()
    {
        $cost = new Cost;
        $cost->setHidden(false);
        $this->assertFalse($cost->getHidden());
    }
    public function testAddPurchaseItem()
    {
        $cost = new Cost;
        $item = new \AppBundle\Entity\PurchaseItem;
        $cost->addPurchaseItem($item);
        $this->assertContains($item,$cost->getPurchaseItems());
    }
    public function testMultipleAddPurchaseItem()
    {
        $cost = new Cost;
        $item = new \AppBundle\Entity\PurchaseItem;
        $item2 = new \AppBundle\Entity\PurchaseItem;
        $cost->addPurchaseItem($item);
        $cost->addPurchaseItem($item2);
        $this->assertContains($item,$cost->getPurchaseItems());
        $this->assertContains($item2,$cost->getPurchaseItems());
    }
    public function testRemovePurchaseItem()
    {
        $cost = new Cost;
        $item = new \AppBundle\Entity\PurchaseItem;
        $item2 = new \AppBundle\Entity\PurchaseItem;
        $item3 = new \AppBundle\Entity\PurchaseItem;
        $cost->addPurchaseItem($item);
        $cost->removePurchaseItem($item);
        $this->assertNotContains($item,$cost->getPurchaseItems());
    }
    public function testMultipleRemovePurchaseItem()
    {
        $cost = new Cost;
        $item = new \AppBundle\Entity\PurchaseItem;
        $item2 = new \AppBundle\Entity\PurchaseItem;
        $item3 = new \AppBundle\Entity\PurchaseItem;
        $cost->addPurchaseItem($item);
        $cost->addPurchaseItem($item2);
        $cost->addPurchaseItem($item3);
        $cost->removePurchaseItem($item);
        $cost->removePurchaseItem($item3);
        $this->assertNotContains($item,$cost->getPurchaseItems());
        $this->assertContains($item2,$cost->getPurchaseItems());
        $this->assertNotContains($item3,$cost->getPurchaseItems());
    }
    

}