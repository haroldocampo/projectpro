<?php
namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Purchase;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\File;
class PurchaseTest extends TestCase
{        
    public function testSetImageFile()
    {   
        $imageFile = new File('web/images/missing_image.png');             
        $purchase = new Purchase;        
        $purchase->setImageFile($imageFile);
        $this->assertEquals($imageFile, $purchase->getImageFile());
    }  
    public function testSetImage()
    {
        $image = 'image.png';
        $purchase = new Purchase;        
        $purchase->setImage($image);
        $this->assertEquals($image, $purchase->getImage());
    }
    public function testSetDateOfPurchase()
    {
        $date = new \DateTime;
        $purchase = new Purchase;        
        $purchase->setDateOfPurchase($date);
        $this->assertEquals($date, $purchase->getDateOfPurchase());
    }
    public function testSetDateCreated()
    {
        $date = new \DateTime;
        $purchase = new Purchase;        
        $purchase->setDateCreated($date);
        $this->assertEquals($date, $purchase->getDateCreated());
    }
    public function testSetStatus()
    {
        $status = 'status';
        $purchase = new Purchase;        
        $purchase->setStatus($status);
        $this->assertEquals($status, $purchase->getStatus());
    }
    public function testSetComments()
    {
        $comments = 'comments';
        $purchase = new Purchase;        
        $purchase->setComments($comments);
        $this->assertEquals($comments, $purchase->getComments());
    }
    public function testAddPurchaseItem()
    {
        $purchaseItem = new \AppBundle\Entity\PurchaseItem;
        $purchase = new Purchase;        
        $purchase->addPurchaseItem($purchaseItem);
        $this->assertContains($purchaseItem, $purchase->getPurchaseItems());
    }
    public function testAddMultiplePurchaseItem()
    {
        $purchaseItem = new \AppBundle\Entity\PurchaseItem;
        $purchaseItem2 = new \AppBundle\Entity\PurchaseItem;
        $purchase = new Purchase;        
        $purchase->addPurchaseItem($purchaseItem);
        $purchase->addPurchaseItem($purchaseItem2);
        $this->assertEquals(2, count($purchase->getPurchaseItems()));
    }
    public function testRemovePurchaseItem()
    {
        $purchaseItem = new \AppBundle\Entity\PurchaseItem;
        $purchase = new Purchase;        
        $purchase->addPurchaseItem($purchaseItem);
        $purchase->removePurchaseItem($purchaseItem);
        $this->assertNotContains($purchaseItem, $purchase->getPurchaseItems());
    }
    public function testRemoveMultiplePurchaseItem()
    {
        $purchaseItem = new \AppBundle\Entity\PurchaseItem;
        $purchaseItem2 = new \AppBundle\Entity\PurchaseItem;
        $purchaseItem3 = new \AppBundle\Entity\PurchaseItem;
        $purchase = new Purchase;        
        $purchase->addPurchaseItem($purchaseItem);
        $purchase->addPurchaseItem($purchaseItem2);
        $purchase->addPurchaseItem($purchaseItem3);
        $purchase->removePurchaseItem($purchaseItem2);
        $this->assertContains($purchaseItem, $purchase->getPurchaseItems());
        $this->assertContains($purchaseItem3, $purchase->getPurchaseItems());
        $this->assertNotContains($purchaseItem2, $purchase->getPurchaseItems());
    }
    public function testSetProject()
    {
        $project = new \AppBundle\Entity\Project;
        $purchase = new Purchase;        
        $purchase->setProject($project);        
        $this->assertEquals($project, $purchase->getProject());
    }
    public function testSetPurchaser()
    {
        $purchaser = new \AppBundle\Entity\Employee;
        $purchase = new Purchase;        
        $purchase->setPurchaser($purchaser);        
        $this->assertEquals($purchaser, $purchase->getPurchaser());
    }
    public function testSetReceiptImageUrl()
    {
        $receipt = 'url';
        $purchase = new Purchase;        
        $purchase->setReceiptImageUrl($receipt);
        $this->assertEquals($receipt, $purchase->getReceiptImageUrl());
    }
    public function testSetPaymentType()
    {
        $type = new \AppBundle\Entity\PaymentType;
        $purchase = new Purchase;        
        $purchase->setPaymentType($type);        
        $this->assertEquals($type, $purchase->getPaymentType());
    }
    public function testSetDateApproved()
    {
        $date = new \DateTime;
        $purchase = new Purchase;        
        $purchase->setDateApproved($date);
        $this->assertEquals($date, $purchase->getDateApproved());
    }
    public function testSetDateDeclined()
    {
        $date = new \DateTime;
        $purchase = new Purchase;        
        $purchase->setDateDeclined($date);
        $this->assertEquals($date, $purchase->getDateDeclined());
    }
    public function testSetDateExported()
    {
        $date = new \DateTime;
        $purchase = new Purchase;        
        $purchase->setDateExported($date);
        $this->assertEquals($date, $purchase->getDateExported());
    }
    public function testSetMatchedImportedTransaction()
    {
        $imported = new \AppBundle\Entity\ImportedTransaction;
        $purchase = new Purchase;        
        $purchase->setMatchedImportedTransaction($imported);        
        $this->assertEquals($imported, $purchase->getMatchedImportedTransaction());
    }
    public function testGetAmount()
    {
        $purchaseItem = new \AppBundle\Entity\PurchaseItem;
        $purchaseItem->setAmount(100);
        $purchaseItem2 = new \AppBundle\Entity\PurchaseItem;
        $purchaseItem2->setAmount(50);        
        $purchase = new Purchase;        
        $purchase->addPurchaseItem($purchaseItem);
        $purchase->addPurchaseItem($purchaseItem2);
        $this->assertEquals(150,$purchase->getAmount());
    }
    public function testSetSalesTax()
    {
        $tax = '1234';
        $purchase = new Purchase;        
        $purchase->setSalesTax($tax);
        $this->assertEquals($tax, $purchase->getSalesTax());
    }
    public function testSetUpdatedAt()
    {
        $date = new \DateTime;
        $purchase = new Purchase;        
        $purchase->setUpdatedAt($date);
        $this->assertEquals($date, $purchase->getUpdatedAt());
    }
    public function testTotalAmount()
    {
        $total = 'url';
        $purchase = new Purchase;        
        $purchase->setTotalAmount($total);
        $this->assertEquals($total, $purchase->getTotalAmount());
    }
    public function testSetApprover()
    {
        $approver = new \AppBundle\Entity\Employee;
        $purchase = new Purchase;        
        $purchase->setApprover($approver);        
        $this->assertEquals($approver, $purchase->getApprover());
    }
    public function testSetDecliner()
    {
        $decliner = new \AppBundle\Entity\Employee;
        $purchase = new Purchase;        
        $purchase->setDecliner($decliner);        
        $this->assertEquals($decliner, $purchase->getDecliner());
    }
    public function testSetOverrideSalesTaxEnabled()
    {
        $purchase = new Purchase;        
        $purchase->setIsOverrideSalesTax(true);        
        $this->assertTrue($purchase->getIsOverrideSalesTax());
    }
    public function testSetOverrideSalesTaxDisabled()
    {
        $purchase = new Purchase;        
        $purchase->setIsOverrideSalesTax(false);        
        $this->assertFalse($purchase->getIsOverrideSalesTax());
    }
    public function testSetVendor()
    {
        $vendor = new \AppBundle\Entity\Vendor;
        $purchase = new Purchase;        
        $purchase->setVendor($vendor);        
        $this->assertEquals($vendor, $purchase->getVendor());        
    }
    public function testSetQbImportTrue()
    {
        $purchase = new Purchase;        
        $purchase->setQbImport(true);        
        $this->assertTrue($purchase->getQbImport());
    }
    public function testSetQbImportFalse()
    {
        $purchase = new Purchase;        
        $purchase->setQbImport(false);        
        $this->assertFalse($purchase->getQbImport());
    }
}