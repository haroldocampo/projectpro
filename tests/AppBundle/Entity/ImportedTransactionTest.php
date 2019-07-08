<?php
namespace Tests\AppBundle\Entity;

use AppBundle\Entity\ImportedTransaction;
use PHPUnit\Framework\TestCase;
class ImportedTransactionTest extends TestCase
{        

    public function testSetDescription()
    {
        $imported = new ImportedTransaction;
        $imported->setDescription('description');
        $this->assertEquals('description',$imported->getDescription());
    }
    public function testSetAccountNumber()
    {
        $imported = new ImportedTransaction;
        $imported->setAccountNumber('1234');
        $this->assertEquals('1234',$imported->getAccountNumber());
    }
    public function testSetAmount()
    {
        $imported = new ImportedTransaction;
        $imported->setAmount('1234');
        $this->assertEquals('1234',$imported->getAmount());
    }
    public function testSetDateCreated()
    {
        $date = date('Y-m-d H:i:s');
        $imported = new ImportedTransaction;
        $imported->setDateCreated($date);
        $this->assertEquals($date,$imported->getDateCreated());
    }
    public function testSetDate()
    {
        $date = date('Y-m-d H:i:s');
        $imported = new ImportedTransaction;
        $imported->setDate($date);
        $this->assertEquals($date,$imported->getDate());
    }
    public function testSetCompany()
    {
        $company = new \AppBundle\Entity\Company;
        $imported = new ImportedTransaction;
        $imported->setCompany($company);
        $this->assertEquals($company, $imported->getCompany());
    }
    public function testSetMatchedPurchase()
    {
        $purchase = new \AppBundle\Entity\Purchase;
        $imported = new ImportedTransaction;
        $imported->setMatchedPurchase($purchase);
        $this->assertEquals($purchase,$imported->getMatchedPurchase());
    }
    public function testSetIsDuplicateTrue()
    {
        $imported = new ImportedTransaction;
        $imported->setIsDuplicate(true);
        $this->assertTrue($imported->getIsDuplicate());
    }
    public function testSetIsDuplicateFalse()
    {
        $imported = new ImportedTransaction;
        $imported->setIsDuplicate(false);
        $this->assertFalse($imported->getIsDuplicate());
    }        
}