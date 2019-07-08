<?php
namespace Tests\AppBundle\Entity;

use AppBundle\Entity\EmployeePaymentType;
use PHPUnit\Framework\TestCase;
class EmployeePaymentTypeTest extends TestCase
{        
    public function testSetEmployee()
    {
        $employee_payment = new EmployeePaymentType;
        $employee = new \AppBundle\Entity\Employee;
        $employee_payment->setEmployee($employee);            
        $this->assertEquals($employee,$employee_payment->getEmployee());
    }  
    public function testSetPaymentType()
    {
        $employee_payment = new EmployeePaymentType;
        $payment_type = new \AppBundle\Entity\PaymentType;
        $employee_payment->setPaymentType($payment_type);
        $this->assertEquals($payment_type, $employee_payment->getPaymentType());
    }
    public function testSetEnabledTrue()
    {
        $employee_payment = new EmployeePaymentType;
        $employee_payment->setEnabled(true);
        $this->assertTrue($employee_payment->getEnabled());
    }
    public function testSetEnabledFalse()
    {
        $employee_payment = new EmployeePaymentType;
        $employee_payment->setEnabled(false);
        $this->assertFalse($employee_payment->getEnabled());
    }
    
}