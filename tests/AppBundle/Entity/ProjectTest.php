<?php
namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Project;
use AppBundle\Entity\Cost;
use PHPUnit\Framework\TestCase;
class ProjectTest extends TestCase
{        
    public function testSetName()
    {
        $project = new Project;
        $name = "project title";
        $project->setName($name);
        $this->assertEquals($name,$project->getName());
    }
    public function testSetTrimName()
    {
        $project = new Project;
        $name = "    project title    ";
        $project->setName($name);
        $this->assertEquals('project title',$project->getName());
    }
    public function testSetNumber()
    {
        $project = new Project;
        $number = "1234";
        $project->setNumber($number);
        $this->assertEquals($number,$project->getNumber());
    }
    public function testSetDateTimeCreated()
    {
        $date = date('Y-m-d H:i:s');
        $project = new Project;
        $project->setDateTimeCreated($date);
        $this->assertEquals($date,$project->getDateTimeCreated());
    }
    public function testSetCompany()
    {
        $company = new \AppBundle\Entity\Company;
        $project = new Project;
        $project->setCompany($company);
        $this->assertEquals($company,$project->getCompany());
    }
    public function testSetApprover()
    {
        $approver = new \AppBundle\Entity\Employee;
        $project = new Project;
        $project->setApprover($approver);
        $this->assertEquals($approver,$project->getApprover());
    }
    public function testAddCost()
    {
        $cost = new \AppBundle\Entity\Cost;
        $project = new Project;
        $project->addCost($cost);
        $this->assertContains($cost,$project->getCosts());
    }
    public function testAddMultipleCosts()
    {
        $cost = new \AppBundle\Entity\Cost;
        $cost2 = new \AppBundle\Entity\Cost;
        $project = new Project;
        $project->addCost($cost);
        $project->addCost($cost2);
        $this->assertContains($cost,$project->getCosts());
        $this->assertContains($cost2,$project->getCosts());
    }
    public function testRemoveCost()
    {
        $cost = new \AppBundle\Entity\Cost;
        $project = new Project;
        $project->addCost($cost);
        $project->removeCost($cost);
        $this->assertNotContains($cost,$project->getCosts());   
    }
    public function testRemoveMultipleCosts()
    {
        $cost = new \AppBundle\Entity\Cost;
        $cost2 = new \AppBundle\Entity\Cost;
        $cost3 = new \AppBundle\Entity\Cost;
        $project = new Project;
        $project->addCost($cost);
        $project->addCost($cost2);
        $project->addCost($cost3);
        $project->RemoveCost($cost2);
        $this->assertContains($cost,$project->getCosts());
        $this->assertNotContains($cost2,$project->getCosts());
        $this->assertContains($cost3,$project->getCosts());
    }
    public function testSetEnabledTrue()
    {
        $project = new Project;
        $project->setEnabled(true);
        $this->assertTrue($project->getEnabled());
    }
    public function testSetEnabledFalse()
    {
        $project = new Project;
        $project->setEnabled(false);
        $this->assertFalse($project->getEnabled());
    }
    public function testAddPurchase()
    {
        $purchase = new \AppBundle\Entity\Purchase;
        $project = new Project;
        $project->addPurchase($purchase);
        $this->assertContains($purchase,$project->getPurchases());        
    }
    public function testAddMultiplePurchases()
    {
        $purchase = new \AppBundle\Entity\Purchase;
        $purchase2 = new \AppBundle\Entity\Purchase;
        $project = new Project;
        $project->addPurchase($purchase);
        $project->addPurchase($purchase2);
        $this->assertContains($purchase,$project->getPurchases());
        $this->assertContains($purchase2,$project->getPurchases());
    }
    public function testRemovePurchase()
    {
        $purchase = new \AppBundle\Entity\Purchase;
        $project = new Project;
        $project->addPurchase($purchase);
        $project->removePurchase($purchase);
        $this->assertNotContains($purchase,$project->getPurchases());   
    }
    public function testRemoveMultiplePurchases()
    {
        $purchase = new \AppBundle\Entity\Purchase;
        $purchase2 = new \AppBundle\Entity\Purchase;
        $purchase3 = new \AppBundle\Entity\Purchase;
        $project = new Project;
        $project->addPurchase($purchase);
        $project->addPurchase($purchase2);
        $project->addPurchase($purchase3);
        $project->removePurchase($purchase2);
        $this->assertContains($purchase,$project->getPurchases());
        $this->assertNotContains($purchase2,$project->getPurchases());
        $this->assertContains($purchase3,$project->getPurchases());   
    }    
    public function testGetPurchasesBetweenDateNotBetween()
    {
        $dateStart = date('Y-m-d', strtotime('2018-01-20'));
        $dateEnd = date('Y-m-d', strtotime('2018-02-20'));
        $purchase = new \AppBundle\Entity\Purchase;
        $purchase->setDateOfPurchase(new \DateTime('2018-02-21'));
        $project = new Project;
        $project->addPurchase($purchase);
        $this->assertNotContains($purchase,$project->getPurchasesBetweenDate($dateStart,$dateEnd));        
    }
    public function testGetPurchasesBetweenDateInMiddle()
    {
        $dateStart = date('Y-m-d', strtotime('2018-01-20'));
        $dateEnd = date('Y-m-d', strtotime('2018-02-20'));
        $purchase = new \AppBundle\Entity\Purchase;
        $purchase->setDateOfPurchase(new \DateTime('2018-02-10'));
        $project = new Project;
        $project->addPurchase($purchase);
        $this->assertContains($purchase,$project->getPurchasesBetweenDate($dateStart,$dateEnd));        
    }
    public function testGetPurchasesBetweenDateInStart()
    {
        $dateStart = date('Y-m-d', strtotime('2018-01-20'));
        $dateEnd = date('Y-m-d', strtotime('2018-02-20'));
        $purchase = new \AppBundle\Entity\Purchase;
        $purchase->setDateOfPurchase(new \DateTime('2018-01-20'));
        $project = new Project;
        $project->addPurchase($purchase);
        $this->assertContains($purchase,$project->getPurchasesBetweenDate($dateStart,$dateEnd));        
    }
    public function testGetPurchasesBetweenDateInEnd()
    {
        $dateStart = date('Y-m-d', strtotime('2018-01-20'));
        $dateEnd = date('Y-m-d', strtotime('2018-02-20'));
        $purchase = new \AppBundle\Entity\Purchase;
        $purchase->setDateOfPurchase(new \DateTime('2018-02-20'));
        $project = new Project;
        $project->addPurchase($purchase);
        $this->assertContains($purchase,$project->getPurchasesBetweenDate($dateStart,$dateEnd));        
    }
}