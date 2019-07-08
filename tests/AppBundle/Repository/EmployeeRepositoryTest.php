<?php
namespace Tests\AppBundle\Repository;

use AppBundle\Entity\Company;
use AppBundle\Entity\Employee;
use Tests\AppBundle\DatabasePrimer;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EmployeeRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;
    private $um;

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

    public function testCreate() {
        $user = $this->em->getRepository('AppBundle:User')
            ->create($this->um, "Test", "User", "test@email.com", "test123", "accountant@email.com");

        $company = new Company();
        $company->setName("Test Company");
        $this->em->persist($company);

        $employee = $this->em->getRepository('AppBundle:Employee')
            ->create($user, $company, ["accountant", "admin", "approver"], true);

        $employees = $this->em
            ->getRepository('AppBundle:Employee')
            ->findAll();
        $this->assertContains($employee, $employees);
    }

    public function testCheckData()
    {
        // $employee = new Employee();
        // $this->em->persist($employee);
        // $this->em->flush();
        $employees = $this->em
            ->getRepository('AppBundle:Employee')
            ->findAll();
        $this->assertEmpty($employees);
    }

    public function testEdit()
    {
        $user = $this->em->getRepository('AppBundle:User')
        ->create($this->um, "Test", "User", "test@email.com", "test123", "accountant@email.com");

        $company = new Company();
        $company->setName("Test Company");
        $this->em->persist($company);

        $employee = $this->em->getRepository('AppBundle:Employee')
            ->create($user, $company, ["accountant", "admin", "approver"], true);
        
        $firstName = "first";
        $lastName = "last";
        $employee = $this->em->getRepository('AppBundle:Employee')
            ->edit($employee->getId(),$firstName, $lastName);

        $this->assertEquals($firstName, $employee->getUser()->getFirstName());
        $this->assertEquals($lastName, $employee->getUser()->getlastName());
        
    }
    public function testDelete()
    {
        $user = $this->em->getRepository('AppBundle:User')
        ->create($this->um, "Test", "User", "test@email.com", "test123", "accountant@email.com");

        $company = new Company();
        $company->setName("Test Company");
        $this->em->persist($company);

        $employee = $this->em->getRepository('AppBundle:Employee')
            ->create($user, $company, ["accountant", "admin", "approver"], true);

        $employee = $this->em->getRepository('AppBundle:Employee')
            ->delete($employee->getId());
        $employees = $this->em->getRepository('AppBundle:Employee')
            ->findAll();
        $this->assertFalse($employees[0]->getEnabled());            
        
    }
    public function testFindByCompanyRole()
    {
        $user = $this->em->getRepository('AppBundle:User')
        ->create($this->um, "Test", "User", "test@email.com", "test123", "accountant@email.com");

        $company = new Company();
        $company->setName("Test Company");
        $this->em->persist($company);
        $company2 = new Company();
        $company2->setName("Test Company2");
        $this->em->persist($company2);

        $employee = $this->em->getRepository('AppBundle:Employee')
            ->create($user, $company, ["accountant", "admin", "approver"], true);
        $employee2 = $this->em->getRepository('AppBundle:Employee')
            ->create($user, $company, ["accountant", "approver"], true);
        $employee3 = $this->em->getRepository('AppBundle:Employee')
            ->create($user, $company2, ["admin", "approver"], true);
        $employees = $this->em->getRepository('AppBundle:Employee')
            ->findByCompanyRole($company, 'ROLE_ADMIN');
        $this->assertContains($employee,$employees);
        $this->assertNotContains($employee2,$employees);
        $this->assertNotContains($employee3,$employees);
    }
    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {

    parent::tearDown();

    $this->em->close();

    $this->em = null;
    $this->um = null;

    gc_collect_cycles();
    }
}