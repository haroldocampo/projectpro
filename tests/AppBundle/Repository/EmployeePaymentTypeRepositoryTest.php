<?php
namespace Tests\AppBundle\Repository;

use AppBundle\Entity\Company;
use AppBundle\Entity\Employee;
use AppBundle\Entity\PaymentType;
use AppBundle\Entity\EmployeePaymentType;
use Tests\AppBundle\DatabasePrimer;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EmployeePaymentTypeRepositoryTest extends KernelTestCase
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

    
    public function testCreateEmployeePaymentTypeWithoutPaymentType()
    {
        $user = $this->em->getRepository('AppBundle:User')
            ->create($this->um, "Test", "User", "test@email.com", "test123", "accountant@email.com");
        $this->em->persist($user);
        $company = new Company();
        $company->setName("Test Company");
        $this->em->persist($company);
        $this->em->flush();

        $employee = $this->em->getRepository('AppBundle:Employee')
            ->create($user, $company, ["accountant", "admin", "approver"], true);
        $this->em->persist($employee);
        $this->em->flush();

        
        $employeePaymentType = $this->em->getRepository('AppBundle:EmployeePaymentType')
            ->create($company,$employee->getId(), "Cash");
        $employeePaymentTypes = $this->em->getRepository('AppBundle:EmployeePaymentType')
            ->findAll();

        $this->assertContains($employeePaymentType,$employeePaymentTypes);    
    }
    public function testCreateEmployeePaymentTypeWithPaymentType()
    {
        $user = $this->em->getRepository('AppBundle:User')
            ->create($this->um, "Test", "User", "test@email.com", "test123", "accountant@email.com");
        $this->em->persist($user);
        $company = new Company();
        $company->setName("Test Company");
        $this->em->persist($company);
        $this->em->flush();

        $employee = $this->em->getRepository('AppBundle:Employee')
            ->create($user, $company, ["accountant", "admin", "approver"], true);
        $this->em->persist($employee);
        $this->em->flush();

        $paymentType = $this->em
            ->getRepository('AppBundle:PaymentType')
            ->create($company,$employee->getId(),"cash");
        $employeePaymentType = $this->em->getRepository('AppBundle:EmployeePaymentType')
            ->create($company,$employee->getId(), $paymentType->getName());
        $employeePaymentTypes = $this->em->getRepository('AppBundle:EmployeePaymentType')
            ->findAll();

        $this->assertContains($employeePaymentType,$employeePaymentTypes);    
    }


    public function testDeleteEmployeePaymentType()
    {
        $user = $this->em->getRepository('AppBundle:User')
            ->create($this->um, "Test", "User", "test@email.com", "test123", "accountant@email.com");
        $this->em->persist($user);
        
        $company = new Company();
        $company->setName("Test Company");
        $this->em->persist($company);
        

        $employee = $this->em->getRepository('AppBundle:Employee')
            ->create($user, $company, ["accountant", "admin", "approver"], true);
        $this->em->persist($employee);
        $this->em->flush();

        $employeePaymentType = $this->em->getRepository('AppBundle:EmployeePaymentType')
            ->create($company,$employee->getId(), "Cash");

        $employeePaymentTypes = $this->em->getRepository('AppBundle:EmployeePaymentType')
            ->delete($company,$employee->getId(),$employeePaymentType->getPaymentType()->getName());    
        $employeePaymentTypes = $this->em->getRepository('AppBundle:EmployeePaymentType')
            ->findAll();

        $this->assertEmpty($employeePaymentTypes);
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