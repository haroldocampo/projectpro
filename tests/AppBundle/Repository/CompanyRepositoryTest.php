<?php
namespace Tests\AppBundle\Repository;

use AppBundle\Entity\Company;
use Tests\AppBundle\DatabasePrimer;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CompanyRepositoryTest extends KernelTestCase
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
    public function testCreate()
    {                            
        // Fields for Company
        $name = "Company 1";
        $company = $this->em
            ->getRepository('AppBundle:Company')
            ->create($name);
            
        $companies = $this->em
            ->getRepository('AppBundle:Company')
            ->findAll();        
            
        $this->assertContains($company,$companies);
    } 
    
    public function testEdit()
    {
        $name = "Company 1";
        $newName = "Company 2";

        $company = $this->em
            ->getRepository('AppBundle:Company')
            ->create($name);
            
        $company = $this->em
            ->getRepository('AppBundle:Company')
            ->edit($company->getId(),$newName);        
            
        $this->assertEquals($newName,$company->getName());
    }
    public function testListByUser()
    {
        $user = $this->em->getRepository('AppBundle:User')
            ->create($this->um, "Test", "User", "test@email.com", "test123", "accountant@email.com");
        $company = new Company();
        $company->setName("Test Company");
        $this->em->persist($company);
        $this->em->flush();        
        $employee = $this->em->getRepository('AppBundle:Employee')
            ->create($user, $company, ["accountant", "admin", "approver"], true);        

        $user2 = $this->em->getRepository('AppBundle:User')
            ->create($this->um, "Test", "User", "test2@email.com", "test123", "accountant@email.com");
        $company2 = new Company();
        $company2->setName("Test Company");
        $this->em->persist($company2);
        $this->em->flush();        
        $employee2 = $this->em->getRepository('AppBundle:Employee')
            ->create($user2, $company2, ["accountant", "admin", "approver"], true);                

        $company3 = new Company();
        $company3->setName("Test Company");
        $this->em->persist($company3);
        $this->em->flush();        
        $employee3 = $this->em->getRepository('AppBundle:Employee')
            ->create($user, $company3, ["accountant", "admin", "approver"], true);

        
        $selectedCompanies = $this->em->getRepository('AppBundle:Company')
            ->listByUser($user);
        $companies = $this->em->getRepository('AppBundle:Company')
            ->findAll();        
        $this->assertEquals($selectedCompanies[0]['companyId'], $company->getId());        
        $this->assertEquals($selectedCompanies[1]['companyId'], $company3->getId());
        $this->assertEquals(3, count($companies));
        $this->assertEquals(2, count($selectedCompanies));
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