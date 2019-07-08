<?php
namespace Tests\AppBundle\Repository;

use Tests\AppBundle\DatabasePrimer;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use AppBundle\Entity\QbException;
use AppBundle\Entity\PurchaseItem;
use AppBundle\Entity\User;
use AppBundle\Entity\Company;
use AppBundle\Entity\Purchase;
use AppBundle\Entity\Project;
use AppBundle\Entity\PaymentType;
use AppBundle\Entity\Vendor;

class QbExceptionRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $kernel = self::bootKernel();
        DatabasePrimer::prime(self::$kernel);
        
        $this->em = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $this->um = $kernel->getContainer()
            ->get('fos_user.user_manager');
    }
    public function testCreate()
    {
        // Fields for QbException
        $errorCode = 1;
        $errorMessage = "Error Message";
        $purchaseItem = $this->createDummyPurchaseItem();
        
        $qbException = $this->em->getRepository('AppBundle:QbException')
            ->create($errorCode, $errorMessage, $purchaseItem);
        
        $this->assertEquals($purchaseItem, $qbException->getPurchaseItem());
        $this->assertEquals($errorCode, $qbException->getErrorCode());
        $this->assertEquals($errorMessage, $qbException->getErrorMessage());
    }
    public function testFindByCompany()
    {
        $purchaseItem = $this->createDummyPurchaseItem();
        $companyId = $purchaseItem->getPurchase()->getProject()->getCompany();        
        $purchaseItem2 = $this->em->getRepository('AppBundle:PurchaseItem')
            ->create("1.00", $purchaseItem->getCost(), "1.00", "2.00", "memo", $purchaseItem->getPurchase());
        $purchaseItem3 = $this->createDummyPurchaseItem('test2@gg.com');


        
        $qbException = $this->em->getRepository('AppBundle:QbException')
            ->create(1, 'hello', $purchaseItem);
        $qbException2 = $this->em->getRepository('AppBundle:QbException')
            ->create(2, 'world', $purchaseItem2);
        $qbException3 = $this->em->getRepository('AppBundle:QbException')
            ->create(3, '!', $purchaseItem3);

        $qbExceptions = $this->em->getRepository('AppBundle:QbException')
            ->findByCompany($companyId);               
        $this->assertContains($qbException, $qbExceptions);
        $this->assertContains($qbException2, $qbExceptions);
        $this->assertNotContains($qbException3, $qbExceptions);
    }

    public function createDummyPurchaseItem($email = "test@email.com")
    {
        
        $company = new Company();
        $company->setName("Test Company");
        $this->em->persist($company);
        $this->em->flush();
        
        $vendor = $this->em
            ->getRepository('AppBundle:Vendor')
            ->create($company,'vendor');

        $user = $this->em->getRepository('AppBundle:User')
            ->create($this->um, "Test", "User", $email, "test123", "accountant@email.com");

        $employee = $this->em->getRepository('AppBundle:Employee')
            ->create($user, $company, ["accountant", "admin", "approver"], true);
        $this->em->flush();
        // Fields for Project
        $name = "Project 1";
        $customer = "Customer 1";
        $number = "1";
        

        $project = $this->em
            ->getRepository('AppBundle:Project')
            ->create($customer,$name,$number,$employee,$company);
        $codeNumber = "1";
        $expenseType = "192";
        $description= "hello";
        $budgetAmount = 1.0;

        $cost = $this->em
            ->getRepository('AppBundle:Cost')
            ->create($project, $codeNumber, $expenseType, $description, $budgetAmount);

        $paymentType = new PaymentType();
        $paymentType->setName('Test Pay')
            ->setCompany($company);
        $this->em->persist($paymentType);

        $purchase = $this->em->getRepository('AppBundle:Purchase')
            ->create($project, Purchase::$STATUS_NOT_APPROVED, '1', $employee, $paymentType, '2.00', null, null, $vendor);

        $purchaseItem = $this->em->getRepository('AppBundle:PurchaseItem')
            ->create("1.00", $cost, "1.00", "2.00", "memo", $purchase);
        return $purchaseItem;
    }
    
    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->em->close();

        $this->em=null;
        $this->um=null;
        gc_collect_cycles();
    }
}
