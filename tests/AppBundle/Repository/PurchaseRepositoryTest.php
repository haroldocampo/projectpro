<?php
/**
 * Created by PhpStorm.
 * User: marksegalle
 * Date: 11/06/2018
 * Time: 3:49 PM
 */

namespace Tests\AppBundle\Repository;


use AppBundle\Entity\Company;
use AppBundle\Entity\PaymentType;
use AppBundle\Entity\Project;
use AppBundle\Entity\Purchase;
use AppBundle\Entity\Vendor;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Tests\AppBundle\DatabasePrimer;

class PurchaseRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;
    private $um;

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

    public function testCreate() {
        $company = new Company();
        $company->setName("Test Company");
        $this->em->persist($company);        
        $this->em->flush();
        $vendor = $this->em->getRepository('AppBundle:Vendor')
        ->create($company,'vendor');

        $user = $this->em->getRepository('AppBundle:User')
            ->create($this->um, "Test", "User", "test@email.com", "test123", "accountant@email.com");

        $employee = $this->em->getRepository('AppBundle:Employee')
            ->create($user, $company, ["accountant", "admin", "approver"], true);

        $project = new Project();
        $project->setCompany($company)
            ->setName('Test Project')
            ->setNumber('123')
            ->setApprover($employee);
        $this->em->persist($project);

        $paymentType = new PaymentType();
        $paymentType->setName('Test Pay')
            ->setCompany($company);
        $this->em->persist($paymentType);
        
        $purchase = $this->em->getRepository('AppBundle:Purchase')
            ->create($project, Purchase::$STATUS_NOT_APPROVED, '1', $employee, $paymentType, '2.00', null, null, $vendor);

        $purchases = $this->em
            ->getRepository('AppBundle:Purchase')
            ->findAll();
        $this->assertContains($purchase, $purchases);
    }
    public function testEdit(){
        $company = new Company();
        $company->setName("Test Company");
        $this->em->persist($company);
        $this->em->flush();
        $vendor = $this->em->getRepository('AppBundle:Vendor')
            ->create($company,'vendor');
            
        $user = $this->em->getRepository('AppBundle:User')
            ->create($this->um, "Test", "User", "test@email.com", "test123", "accountant@email.com");

        $employee = $this->em->getRepository('AppBundle:Employee')
            ->create($user, $company, ["accountant", "admin", "approver"], true);

        $project = new Project();
        $project->setCompany($company)
            ->setName('Test Project')
            ->setNumber('123')
            ->setApprover($employee);
        $this->em->persist($project);

        $paymentType = new PaymentType();
        $paymentType->setName('Test Pay')
            ->setCompany($company);
        $this->em->persist($paymentType);

        $purchase = $this->em->getRepository('AppBundle:Purchase')
            ->create($project, Purchase::$STATUS_NOT_APPROVED, '1', $employee, $paymentType, '2.00', null, null, $vendor);

        // Edit Purchase 
        $totalAmount = 1000;
        $dateOfPurchase = "11-11-2011";
        $purchase = $this->em->getRepository('AppBundle:Purchase')
            ->edit($purchase->getId(), $project, $paymentType, $totalAmount, $dateOfPurchase, Purchase::$IMPORT_DISABLED, $vendor);
        $this->assertEquals($totalAmount, $purchase->getTotalAmount());
        $this->assertEquals(new \DateTime($dateOfPurchase), $purchase->getDateOfPurchase());
    }
    public function testApprove(){
        $company = new Company();
        $company->setName("Test Company");
        $this->em->persist($company);
        $this->em->flush();
        $vendor = $this->em->getRepository('AppBundle:Vendor')
            ->create($company,'vendor');
        $user = $this->em->getRepository('AppBundle:User')
            ->create($this->um, "Test", "User", "test@email.com", "test123", "accountant@email.com");

        $employee = $this->em->getRepository('AppBundle:Employee')
            ->create($user, $company, ["accountant", "admin", "approver"], true);

        $project = new Project();
        $project->setCompany($company)
            ->setName('Test Project')
            ->setNumber('123')
            ->setApprover($employee);
        $this->em->persist($project);

        $paymentType = new PaymentType();
        $paymentType->setName('Test Pay')
            ->setCompany($company);
        $this->em->persist($paymentType);

        $purchase = $this->em->getRepository('AppBundle:Purchase')
            ->create($project, Purchase::$STATUS_NOT_APPROVED, '1', $employee, $paymentType, '2.00', null, null, $vendor);

        // Approve purchase
        $purchase = $this->em->getRepository('AppBundle:Purchase')
            ->approve($purchase->getId(),$employee);                

        $this->assertEquals(Purchase::$STATUS_APPROVED, $purchase->getStatus());
        $this->assertEquals($employee, $purchase->getApprover());
        
    }
    public function testDecline(){
        $company = new Company();
        $company->setName("Test Company");
        $this->em->persist($company);
        $this->em->flush();        
        $vendor = $this->em->getRepository('AppBundle:Vendor')
        ->create($company,'vendor');        

        $user = $this->em->getRepository('AppBundle:User')
            ->create($this->um, "Test", "User", "test@email.com", "test123", "accountant@email.com");

        $employee = $this->em->getRepository('AppBundle:Employee')
            ->create($user, $company, ["accountant", "admin", "approver"], true);

        $project = new Project();
        $project->setCompany($company)
            ->setName('Test Project')
            ->setNumber('123')
            ->setApprover($employee);
        $this->em->persist($project);

        $paymentType = new PaymentType();
        $paymentType->setName('Test Pay')
            ->setCompany($company);
        $this->em->persist($paymentType);

        $purchase = $this->em->getRepository('AppBundle:Purchase')
            ->create($project, Purchase::$STATUS_NOT_APPROVED, '1', $employee, $paymentType, '2.00', null, null, $vendor);

        //Decline the purchase
        $comment = "test comment";        
        $purchase = $this->em->getRepository('AppBundle:Purchase')
            ->decline($purchase->getId(),$employee, $comment);                

        $this->assertEquals(Purchase::$STATUS_DECLINED, $purchase->getStatus());
        $this->assertEquals($comment, $purchase->getComments());
        $this->assertEquals($employee, $purchase->getDecliner());
    }    
    public function testDelete(){
        $company = new Company();
        $company->setName("Test Company");
        $this->em->persist($company);
        $this->em->flush();
        $vendor = $this->em->getRepository('AppBundle:Vendor')
            ->create($company,'vendor');

        $user = $this->em->getRepository('AppBundle:User')
            ->create($this->um, "Test", "User", "test@email.com", "test123", "accountant@email.com");

        $employee = $this->em->getRepository('AppBundle:Employee')
            ->create($user, $company, ["accountant", "admin", "approver"], true);

        $project = new Project();
        $project->setCompany($company)
            ->setName('Test Project')
            ->setNumber('123')
            ->setApprover($employee);
        $this->em->persist($project);

        $paymentType = new PaymentType();
        $paymentType->setName('Test Pay')
            ->setCompany($company);
        $this->em->persist($paymentType);

        $purchase = $this->em->getRepository('AppBundle:Purchase')
            ->create($project, Purchase::$STATUS_NOT_APPROVED, '1', $employee, $paymentType, '2.00', null, null, $vendor);

        $this->em
            ->getRepository('AppBundle:Purchase')
            ->delete($purchase->getId());

        $purchases = $this->em
            ->getRepository('AppBundle:Purchase')
            ->findAll();
        $this->assertEmpty($purchases);
    }

    public function testFindAllUnapprovedByEmployee(){
        $company = new Company();
        $company->setName("Test Company");
        $this->em->persist($company);
        $this->em->flush();
        $vendor = $this->em->getRepository('AppBundle:Vendor')
            ->create($company,'vendor');

        $user = $this->em->getRepository('AppBundle:User')
            ->create($this->um, "Test", "User", "test@email.com", "test123", "accountant@email.com");
        $user2 = $this->em->getRepository('AppBundle:User')
            ->create($this->um, "Test", "User", "gg@email.com", "test123", "gg@email.com");

        $employee = $this->em->getRepository('AppBundle:Employee')
            ->create($user, $company, ["accountant", "admin", "approver"], true);
        $employee2 = $this->em->getRepository('AppBundle:Employee')
            ->create($user2, $company, ["accountant", "admin", "approver"], true);

        
        $project = new Project();
        $project->setCompany($company)
            ->setName('Test Project')
            ->setNumber('123')
            ->setApprover($employee);
        $this->em->persist($project);
        
        $project2 = new Project();
        $project2->setCompany($company)
            ->setName('Test Project')
            ->setNumber('123')
            ->setApprover($employee2);
        $this->em->persist($project2);

        $paymentType = new PaymentType();
        $paymentType->setName('Test Pay')
            ->setCompany($company);
        $this->em->persist($paymentType);

        $purchase = $this->em->getRepository('AppBundle:Purchase')
            ->create($project, Purchase::$STATUS_NOT_APPROVED, '1', $employee, $paymentType, '2.00', null, null, $vendor);
        $purchase2 = $this->em->getRepository('AppBundle:Purchase')
            ->create($project, Purchase::$STATUS_APPROVED, '2', $employee, $paymentType, '2.00', null, null, $vendor);
        $purchase3 = $this->em->getRepository('AppBundle:Purchase')
            ->create($project2, Purchase::$STATUS_NOT_APPROVED, '3', $employee2, $paymentType, '2.00', null, null, $vendor);
        
        $purchases = $this->em
            ->getRepository('AppBundle:Purchase')    
            ->findAllUnapprovedByEmployee($employee->getId());        

        $this->assertContains($purchase, $purchases);
        $this->assertNotContains($purchase2, $purchases);
        $this->assertNotContains($purchase3, $purchases);
    }
    public function testToggleImport()
    {
        $company = new Company();
        $company->setName("Test Company");
        $this->em->persist($company);
        $this->em->flush();
        $vendor = $this->em->getRepository('AppBundle:Vendor')
            ->create($company,'vendor');
            
        $user = $this->em->getRepository('AppBundle:User')
            ->create($this->um, "Test", "User", "test@email.com", "test123", "accountant@email.com");

        $employee = $this->em->getRepository('AppBundle:Employee')
            ->create($user, $company, ["accountant", "admin", "approver"], true);

        
        $project = new Project();
        $project->setCompany($company)
            ->setName('Test Project')
            ->setNumber('123')
            ->setApprover($employee);
        $this->em->persist($project);    

        $paymentType = new PaymentType();
        $paymentType->setName('Test Pay')
            ->setCompany($company);

        $this->em->persist($paymentType);

        $purchase = $this->em->getRepository('AppBundle:Purchase')
            ->create($project, Purchase::$STATUS_NOT_APPROVED, '1', $employee, $paymentType, '2.00', null, null, $vendor);        
        
            $purchase = $this->em->getRepository('AppBundle:Purchase')
            ->toggleImport($purchase->getId(), Purchase::$IMPORT_PENDING);        
        $this->assertEquals("PENDING",$purchase->getQbImport());
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