<?php
namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Company;
use PHPUnit\Framework\TestCase;
class CompanyTest extends TestCase
{        
    public function testSetName()
    {
        $company = new Company;
        $company->setName("ABC");        
        $this->assertEquals("ABC",$company->getName());
    }  
    public function testSetNameTrim()
    {
        $company = new Company;
        $company->setName("   ABC    ");                
        $this->assertEquals("ABC",$company->getName());
    }  
    public function testSetDateTimeCreated()
    {
        $company = new Company;
        $date = date('d M Y H:i:s');
        $company->setDateTimeCreated($date);
        $this->assertEquals($date,$company->getDateTimeCreated());
    }

    public function testAddEmployee()
    {
        $company = new Company;        
        $employee = new \AppBundle\Entity\Employee;
        $employee2 = new \AppBundle\Entity\Employee;
        $company->addEmployee($employee);
        $company->addEmployee($employee2);
        $this->assertContains($employee,$company->getEmployees());
        $this->assertContains($employee2,$company->getEmployees());
    }
    public function testRemoveEmployee()
    {
        $company = new Company;        
        $employee = new \AppBundle\Entity\Employee;
        $employee2 = new \AppBundle\Entity\Employee;
        $company->addEmployee($employee2);
        $company->addEmployee($employee);        
        $company->removeEmployee($employee);
        $this->assertNotContains($employee,$company->getEmployees());
        $this->assertContains($employee2,$company->getEmployees());
    }
    public function testAddProject()
    {
        $company = new Company;        
        $project = new \AppBundle\Entity\Project;
        $project2 = new \AppBundle\Entity\Project;
        $company->addProject($project);
        $company->addProject($project2);
        $this->assertContains($project,$company->getProjects());    
        $this->assertContains($project2,$company->getProjects());    
    }

    public function testRemoveProject()
    {
        $company = new Company;        
        $project = new \AppBundle\Entity\Project;
        $project2 = new \AppBundle\Entity\Project;
        $company->addProject($project);
        $company->addProject($project2);
        $company->removeProject($project);
        $this->assertNotContains($project,$company->getProjects());        
        $this->assertContains($project2,$company->getProjects());        
    }
    public function testAddReminderJob()
    {
        $company = new Company;        
        $reminderJob = new \AppBundle\Entity\ReminderJob;
        $company->addReminderJob($reminderJob);        
        $this->assertContains($reminderJob,$company->getReminderJobs());        
    }

    public function testRemoveReminderJob()
    {
        $company = new Company;        
        $reminderJob = new \AppBundle\Entity\ReminderJob;
        $company->addReminderJob($reminderJob);
        $company->removeReminderJob($reminderJob);
        $this->assertNotContains($reminderJob, $company->getReminderJobs());        
    }
    public function testAddDisabledExpenseType()
    {
        $company = new Company;        
        $disabled = new \AppBundle\Entity\DisabledExpenseType;
        $company->addDisabledExpenseType($disabled);
        $this->assertContains($disabled,$company->getDisabledExpenseTypes());
    }

    public function testRemoveDisabledExpenseType()
    {
        $company = new Company;        
        $disabled = new \AppBundle\Entity\DisabledExpenseType;
        $company->addDisabledExpenseType($disabled);
        $company->removeDisabledExpenseType($disabled);
        $this->assertEmpty($company->getDisabledExpenseTypes());                
    }
    public function testAddPaymentType()
    {
        $company = new Company;
        $paymentType = new \AppBundle\Entity\PaymentType;
        $company->addPaymentType($paymentType);
        $this->assertContains($paymentType,$company->getPaymentTypes());
    }
    public function testRemovePaymentType()
    {
        $company = new Company;
        $paymentType = new \AppBundle\Entity\PaymentType;
        $company->addPaymentType($paymentType);
        $company->removePaymentType($paymentType);
        $this->assertNotContains($paymentType,$company->getPaymentTypes());
    }
    public function testAddImportedTransaction()
    {
        $company = new Company;
        $imported = new \AppBundle\Entity\ImportedTransaction;
        $company->addImportedTransaction($imported);
        $this->assertContains($imported,$company->getImportedTransactions());
    }
    public function testRemoveImportedTransaction()
    {
        $company = new Company;
        $imported = new \AppBundle\Entity\ImportedTransaction;
        $company->addImportedTransaction($imported);
        $company->removeImportedTransaction($imported);
        $this->assertNotContains($imported,$company->getImportedTransactions());
    }
    public function testSetSubscriptionId()
    {
        $company = new Company;        
        $company->setSubscriptionId(10);
        $this->assertEquals(10,$company->getSubscriptionId());
    }
    public function testBillingPortalLink()
    {
        $company = new Company;        
        $company->setBillingPortalLink("billingportal");
        $this->assertEquals("billingportal",$company->getBillingPortalLink());
    }
    public function testSetQbIntegrationEnabled()
    {
        $company = new Company;
        $company->setQbIntegrated(true);
        $this->assertTrue($company->isQbIntegrated());
    }    
}