<?php
/**
 * Created by PhpStorm.
 * User: marksegalle
 * Date: 13/06/2018
 * Time: 10:02 AM
 */

namespace Tests\AppBundle\Repository;

use AppBundle\Entity\Company;
use AppBundle\Entity\PaymentType;
use AppBundle\Entity\Project;
use AppBundle\Entity\Purchase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Tests\AppBundle\DatabasePrimer;

class PurchaseItemRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;
    private $um;

    protected function setUp() {
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
        $vendor = $this->em->getRepository('AppBundle:Vendor')
        ->create($company,'vendor');

        $user = $this->em->getRepository('AppBundle:User')
            ->create($this->um, "Test", "User", "test@email.com", "test123", "accountant@email.com");

        $employee = $this->em->getRepository('AppBundle:Employee')
            ->create($user, $company, ["accountant", "admin", "approver"], true);

        $project = new Project();
        $project->setName('proj')
            ->setNumber('123');
        $this->em->persist($project);
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

        $purchaseItems = $this->em->getRepository('AppBundle:PurchaseItem')
            ->findAll();

        $this->assertContains($purchaseItem, $purchaseItems);
    }
    public function testDelete() {
        $company = new Company();
        $company->setName("Test Company");
        $this->em->persist($company);

        $vendor = $this->em->getRepository('AppBundle:Vendor')
        ->create($company,'vendor');
        $user = $this->em->getRepository('AppBundle:User')
            ->create($this->um, "Test", "User", "test@email.com", "test123", "accountant@email.com");

        $employee = $this->em->getRepository('AppBundle:Employee')
            ->create($user, $company, ["accountant", "admin", "approver"], true);

        $project = new Project();
        $project->setName('proj')
            ->setNumber('123');
        $this->em->persist($project);
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
            ->create("1.00", $cost, "1.00", "2.00", "memo",$purchase);
        $this->em->getRepository('AppBundle:PurchaseItem')
            ->delete($purchaseItem->getId());
        $purchaseItems = $this->em->getRepository('AppBundle:PurchaseItem')
            ->findAll();

        $this->assertEmpty($purchaseItems);
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