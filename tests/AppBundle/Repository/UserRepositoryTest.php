<?php
namespace Tests\AppBundle\Repository;

use AppBundle\Entity\User;
use AppBundle\Entity\Company;
use Tests\AppBundle\DatabasePrimer;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Psr\Container\ContainerInterface;
class UserRepositoryTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;
    private $um;
    private $container;
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
        // $this->container = $kernel->getContainer();
    }

    public function testCreate()
    {                        
        $email = "harold0campo@live.com";
        $password = "secret";        
        $firstName = "Harold";
        $lastName = "Ocampo";
        $accountantEmail= "harold0campo@live.com";
        
        $user = $this->em
        ->getRepository('AppBundle:User')
        ->create($this->um, $firstName, $lastName, $email, $password, $accountantEmail);  

        $users = $this->em
            ->getRepository('AppBundle:User')
            ->findAll();        
        
        $this->assertContains($user,$users);
    }
    public function testCreateWithoutAccountantEmail()
    {                        
        $email = "harold0campo@live.com";
        $password = "secret";        
        $firstName = "Harold";
        $lastName = "Ocampo";
        $accountantEmail= "harold0campo@live.com";
        
        $user = $this->em
        ->getRepository('AppBundle:User')
        ->create($this->um, $firstName, $lastName, $email, $password);  

        $users = $this->em
            ->getRepository('AppBundle:User')
            ->findAll();        
        
        $this->assertContains($user,$users);
    }
    public function testFindCompanies()
    {
        $company = new Company;
        $company->setName('c1');
        $this->em->persist($company);
        $company2 = new Company;
        $company2->setName('c2');
        $this->em->persist($company2);
        $this->em->flush();

        $user = $this->em->getRepository('AppBundle:User')
        ->create($this->um, "Test", "User", "test@email.com", "test123", "accountant@email.com");
        
        $employee = $this->em->getRepository('AppBundle:Employee')
        ->create($user, $company, ["accountant", "admin", "approver"], true);

        $companies = $this->em->getRepository('AppBundle:User')
        ->findCompanies($user, false);
        $this->assertEquals(1, count($companies));
        $this->assertEquals($company->getName(), $companies[0]["name"]);
    }
    public function testFindCompaniesAdmin()
    {
        $company = new Company;
        $company->setName('c1');
        $this->em->persist($company);
        $company2 = new Company;
        $company2->setName('c2');
        $this->em->persist($company2);
        $this->em->flush();

        $user = $this->em->getRepository('AppBundle:User')
        ->create($this->um, "Test", "User", "test@email.com", "test123", "accountant@email.com");
        
        $employee = $this->em->getRepository('AppBundle:Employee')
        ->create($user, $company, ["accountant", "admin", "approver"], true);

        $companies = $this->em->getRepository('AppBundle:User')
        ->findCompanies($user, true);

        $this->assertEquals(2, count($companies));
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