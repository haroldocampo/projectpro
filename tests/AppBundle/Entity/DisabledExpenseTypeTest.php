<?php
namespace Tests\AppBundle\Entity;

use AppBundle\Entity\DisabledExpenseType;
use PHPUnit\Framework\TestCase;
class DisabledExpenseTypeTest extends TestCase
{        
    public function testSetName()
    {
        $disabled = new DisabledExpenseType;
        $disabled->setName("ABC");        
        $this->assertEquals("ABC",$disabled->getName());
    }  
    public function testTrimName()
    {
        $disabled = new DisabledExpenseType;
        $disabled->setName("   ABC   ");        
        $this->assertEquals("ABC",$disabled->getName());
    }  
    public function testSetCompany()
    {
        $disabled = new DisabledExpenseType;
        $company = new \AppBundle\Entity\Company;        
        $disabled->setCompany($company);   
        $this->assertEquals($company, $disabled->getCompany());
    }
}