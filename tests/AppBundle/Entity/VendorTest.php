<?php
namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Vendor;
use AppBundle\Entity\Company;
use PHPUnit\Framework\TestCase;
class VendorTest extends TestCase
{        
    public function testGetSetName()
    {
        $name = "Test";
        $vendor = new Vendor;
        $vendor->setName($name);
        $this->assertEquals($name, $vendor->getName());
    }     
    public function testGetSetMergeId()
    {
        $mergeId = 1;
        $vendor = new Vendor;
        $vendor->setMergeId($mergeId);
        $this->assertEquals($mergeId,$vendor->getMergeId());
    }
    public function testGetSetCompany()
    {
        $company = new Company;
        $vendor = new Vendor;
        $vendor->setCompany($company);
        $this->assertEquals($company,$vendor->getCompany());
    }
}