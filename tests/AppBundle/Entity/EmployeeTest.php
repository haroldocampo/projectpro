<?php
namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Employee;
use PHPUnit\Framework\TestCase;
class EmployeeTest extends TestCase
{        
    public function testAddRole()
    {
        $employee = new Employee;
        $employee->addRole(Employee::$ROLE_PURCHASER);        
        $employee->addRole(Employee::$ROLE_ACCOUNTANT);          
        $this->assertContains(Employee::$ROLE_PURCHASER,$employee->getRoles());        
        $this->assertContains(Employee::$ROLE_ACCOUNTANT,$employee->getRoles());        
    }  
    public function testAddMultipleRoles()
    {
        $employee = new Employee;
        $roles = array();
        $roles[] = Employee::$ROLE_PURCHASER;
        $roles[] = Employee::$ROLE_ACCOUNTANT;
        $employee->addRole(Employee::$ROLE_ADMIN);
        $employee->setRoles($roles);                
        $this->assertContains(Employee::$ROLE_PURCHASER,$employee->getRoles());        
        $this->assertContains(Employee::$ROLE_ACCOUNTANT,$employee->getRoles());        
        $this->assertNotContains(Employee::$ROLE_ADMIN,$employee->getRoles());        
    }  
    public function testRemoveRole()
    {
        $employee = new Employee;
        $employee->addRole(Employee::$ROLE_PURCHASER);        
        $employee->addRole(Employee::$ROLE_ACCOUNTANT);         
        $employee->removeRole(Employee::$ROLE_ACCOUNTANT);
        $this->assertContains(Employee::$ROLE_PURCHASER,$employee->getRoles());        
        $this->assertNotContains(Employee::$ROLE_ACCOUNTANT,$employee->getRoles());        
    }  
    public function testHasRole()
    {
        $employee = new Employee;
        $employee->addRole(Employee::$ROLE_PURCHASER);        
        $employee->addRole(Employee::$ROLE_ACCOUNTANT); 
        $employee->removeRole(Employee::$ROLE_ACCOUNTANT);        
        $this->assertTrue($employee->hasRole(Employee::$ROLE_PURCHASER));
        $this->assertFalse($employee->hasRole(Employee::$ROLE_ACCOUNTANT));
    }
    public function testSetDateTimeCreated()
    {
        $employee = new Employee;
        $date = date('Y-m-d H:i:s');
        $employee->setDateTimeCreated($date);

        $this->assertEquals($date,$employee->getDateTimeCreated());
    }
    public function testSetCompany()
    {
        $employee = new Employee;
        $company = new \AppBundle\Entity\Company;
        $employee->setCompany($company);
        $this->assertEquals($company,$employee->getCompany());
    }    
    public function testAddApprovedProject()
    {
        $project = new \AppBundle\Entity\Project;
        $employee = new Employee;
        $employee->AddApprovedProject($project);
        $this->assertContains($project, $employee->getApprovedProjects());

    }
    public function testRemoveApprovedProject()
    {
        $project = new \AppBundle\Entity\Project;
        $employee = new Employee;
        $employee->addApprovedProject($project);
        $employee->removeApprovedProject($project);
        $this->assertNotContains($project, $employee->getApprovedProjects());
    }
    public function testAddPurchase()
    {
        $purchase = new \AppBundle\Entity\Purchase;
        $employee = new Employee;
        $employee->addPurchase($purchase);
        $employee->removePurchase($purchase);
        $this->assertNotContains($purchase, $employee->getPurchases());
    }
    public function testRemovePurchase()
    {
        $purchase = new \AppBundle\Entity\Purchase;
        $employee = new Employee;
        $employee->addPurchase($purchase);
        $employee->removePurchase($purchase);
        $this->assertNotContains($purchase, $employee->getPurchases());
    }
    public function testAddEmploymentPaymentType()
    {
        $paymentType = new \AppBundle\Entity\EmployeePaymentType;
        $employee = new Employee;
        $employee->addEmployeePaymentType($paymentType);
        $employee->removeEmployeePaymentType($paymentType);
        $this->assertNotContains($paymentType, $employee->getEmployeePaymentTypes());
    }
    public function testRemoveEmploymentPaymentType()
    {
        $paymentType = new \AppBundle\Entity\EmployeePaymentType;
        $employee = new Employee;
        $employee->addEmployeePaymentType($paymentType);
        $employee->removeEmployeePaymentType($paymentType);
        $this->assertNotContains($paymentType, $employee->getEmployeePaymentTypes());
    }
    public function testSetEnabledTrue()
    {
        $employee = new Employee;
        $employee->setEnabled(true);
        $this->assertTrue($employee->getEnabled());
    }
    public function testSetEnabledFalse()
    {
        $employee = new Employee;
        $employee->setEnabled(false);
        $this->assertFalse($employee->getEnabled());
    }
    public function testSetIsDoneWizardTrue()
    {
        $employee = new Employee;
        $employee->setIsDoneWizard(true);
        $this->assertTrue($employee->getIsDoneWizard());
    }
    public function testSetIsDoneWizardFalse()
    {
        $employee = new Employee;
        $employee->setIsDoneWizard(false);
        $this->assertFalse($employee->getIsDoneWizard());
    }
    public function testSetDefaultAccountantTrue()
    {
        $employee = new Employee;
        $employee->setIsDefaultAccountant(true);
        $this->assertTrue($employee->getIsDefaultAccountant());
    }
    public function testSetDefaultAccountantFalse()
    {
        $employee = new Employee;
        $employee->setIsDefaultAccountant(false);
        $this->assertFalse($employee->getIsDefaultAccountant());
    }
    public function setChargifyCustomerId()
    {
        $employee = new Employee;
        $employee->setChargifyCustomerId('chargify');
        $this->assertEquals('chargify',$employee->getChargifyCustomerId());
    }
    
    
}