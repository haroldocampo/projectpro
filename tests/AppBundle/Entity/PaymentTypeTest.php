<?php
namespace Tests\AppBundle\Entity;

use AppBundle\Entity\PaymentType;
use PHPUnit\Framework\TestCase;
class PaymentTypeTest extends TestCase
{        
    public function testSetName()
    {
        $name = "Ran";
        $payment = new PaymentType;
        $payment->setName($name);
        $this->assertEquals($name,$payment->getName());
    }  
    public function testSetDateCreated()
    {
        $date = date('Y-m-d H:i:s');
        $payment = new PaymentType;
        $payment->setDateCreated($date);
        $this->assertEquals($date,$payment->getDateCreated());        
    }
    public function testSetCompany()
    {
        $company = new \AppBundle\Entity\Company;
        $payment = new PaymentType;
        $payment->setCompany($company);
        $this->assertEquals($company,$payment->getCompany());
    }
    public function testAddPurchase()
    {
        $purchase = new \AppBundle\Entity\Purchase;
        $payment = new PaymentType;
        $payment->addPurchase($purchase);
        $this->assertContains($purchase, $payment->getPurchases());
    }
    public function testAddMultiplePurchases()
    {
        $purchase = new \AppBundle\Entity\Purchase;
        $purchase2 = new \AppBundle\Entity\Purchase;
        $payment = new PaymentType;        
        $payment->addPurchase($purchase);
        $payment->addPurchase($purchase2);
        $this->assertContains($purchase, $payment->getPurchases());
        $this->assertContains($purchase2, $payment->getPurchases());
    }
    public function testRemovePurchase()
    {
        $purchase = new \AppBundle\Entity\Purchase;        
        $payment = new PaymentType;
        $payment->addPurchase($purchase);
        $payment->removePurchase($purchase);
        $this->assertNotContains($payment, $payment->getPurchases());
    }
    public function testRemoveMultiplePurchases()
    {
        $purchase = new \AppBundle\Entity\Purchase;
        $purchase2 = new \AppBundle\Entity\Purchase;
        $purchase3 = new \AppBundle\Entity\Purchase;
        $payment = new PaymentType;
        $payment->addPurchase($purchase);
        $payment->addPurchase($purchase2);
        $payment->addPurchase($purchase3);
        $payment->removePurchase($purchase);
        $this->assertNotContains($purchase, $payment->getPurchases());
        $this->assertContains($purchase2, $payment->getPurchases());
        $this->assertContains($purchase3, $payment->getPurchases());
    }
    public function testHasPurchaseTrue()
    {
        $purchase = new \AppBundle\Entity\Purchase;
        $payment = new PaymentType;
        $payment->addPurchase($purchase);
        $this->assertTrue($payment->getHasPurchases());
    }
    public function testHasPurchaseFalse()
    {
        $payment = new PaymentType;        
        $this->assertFalse($payment->getHasPurchases());
    }
    public function testAddEmployeePaymentType()
    {
        $employee_payment = new \AppBundle\Entity\EmployeePaymentType;
        $payment = new PaymentType;
        $payment->addEmployeePaymentType($employee_payment);
        $this->assertContains($employee_payment,$payment->getEmployeePaymentTypes());
    }
    public function testAddMultipleEmployeePaymentTypes()
    {
        $employee_payment = new \AppBundle\Entity\EmployeePaymentType;
        $employee_payment2 = new \AppBundle\Entity\EmployeePaymentType;
        $payment = new PaymentType;
        $payment->addEmployeePaymentType($employee_payment);
        $payment->addEmployeePaymentType($employee_payment2);
        $this->assertContains($employee_payment,$payment->getEmployeePaymentTypes());
        $this->assertContains($employee_payment2,$payment->getEmployeePaymentTypes());
    }
    public function testRemoveEmployeePaymentType()
    {
        $employee_payment = new \AppBundle\Entity\EmployeePaymentType;
        $payment = new PaymentType;
        $payment->addEmployeePaymentType($employee_payment);
        $payment->removeEmployeePaymentType($employee_payment);
        $this->assertNotContains($employee_payment,$payment->getEmployeePaymentTypes());
    }
    public function testRemoveMultipleEmployeePaymentTypes()
    {
        $employee_payment = new \AppBundle\Entity\EmployeePaymentType;
        $employee_payment2 = new \AppBundle\Entity\EmployeePaymentType;
        $employee_payment3 = new \AppBundle\Entity\EmployeePaymentType;
        $payment = new PaymentType;
        $payment->addEmployeePaymentType($employee_payment);
        $payment->addEmployeePaymentType($employee_payment2);
        $payment->addEmployeePaymentType($employee_payment3);
        $payment->removeEmployeePaymentType($employee_payment2);
        $this->assertContains($employee_payment,$payment->getEmployeePaymentTypes());
        $this->assertNotContains($employee_payment2,$payment->getEmployeePaymentTypes());
        $this->assertContains($employee_payment3,$payment->getEmployeePaymentTypes());
    }
    public function testHasEmployeePaymentTypesTrue()
    {
        $employee_payment = new \AppBundle\Entity\EmployeePaymentType;
        $payment = new PaymentType;
        $payment->addEmployeePaymentType($employee_payment);
        $this->assertTrue($payment->getHasEmployeePaymentTypes());
    }
    public function testHasEmployeePaymentTypesFalse()
    {
        $payment = new PaymentType;        
        $this->assertFalse($payment->getHasEmployeePaymentTypes());
    }
    
    public function testSetEnabledTrue()
    {
        $payment = new PaymentType;
        $payment->setEnabled(true);
        $this->assertTrue($payment->getEnabled());
    }
    public function testSetEnabledFalse()
    {
        $payment = new PaymentType;
        $payment->setEnabled(false);
        $this->assertFalse($payment->getEnabled());
    }
    
}