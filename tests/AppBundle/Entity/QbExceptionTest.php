<?php
namespace Tests\AppBundle\Entity;

use AppBundle\Entity\QbException;
use AppBundle\Entity\PurchaseItem;
use PHPUnit\Framework\TestCase;
class QbExceptionTest extends TestCase
{        
    public function testSetErrorCode()
    {                
        $qbException = new QbException;
        $qbException->setErrorCode(1);        
        $this->assertEquals(1,$qbException->getErrorCode());
    }      
    public function testSetErrorMessage()
    {
        $qbException = new QbException;
        $qbException->setErrorMessage(QbException::$error_messages[1]);        
        $this->assertEquals(QbException::$error_messages[1],$qbException->getErrorMessage());
    }
    public function testSetPurchaseItem()
    {       
        $purchaseItem = new PurchaseItem;
        $qbException = new QbException;
        $qbException->setPurchaseItem($purchaseItem);        
        $this->assertEquals($purchaseItem,$qbException->getPurchaseItem());        
    }
}