<?php
namespace Tests\AppBundle\Repository;

use AppBundle\Entity\Company;
use AppBundle\Entity\Project;
use AppBundle\Entity\Cost;
use Tests\AppBundle\DatabasePrimer;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProjectRepositoryTest extends KernelTestCase
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
        $user = $this->em->getRepository('AppBundle:User')
            ->create($this->um, "Test", "User", "test@email.com", "test123", "accountant@email.com");
        $company = new Company();  
        $company->setName('test company');
        $this->em->persist($company);        
        $dateTime = new \DateTime();    

        $approver = $this->em->getRepository('AppBundle:Employee')
            ->create($user, $company, ["accountant", "admin", "approver"], true);

        // Fields for Project
        $customer = "Customer 1";
        $name = "Project 1";
        $number = "1";
        

        $project = $this->em
            ->getRepository('AppBundle:Project')
            ->create($customer,$name,$number,$approver,$company);
            
        $projects = $this->em
            ->getRepository('AppBundle:Project')
            ->findAll();        
            
        $this->assertContains($project,$projects);
    } 
    public function testIsDuplicateName()
    {   
        $user = $this->em->getRepository('AppBundle:User')
            ->create($this->um, "Test", "User", "test@email.com", "test123", "accountant@email.com");
        $company = new Company();  
        $company->setName('test company');
        $this->em->persist($company);        
        $dateTime = new \DateTime();    

        $approver = $this->em->getRepository('AppBundle:Employee')
            ->create($user, $company, ["accountant", "admin", "approver"], true);

        // Fields for Project
        $customer = "Customer 1";
        $name = "Project 1";        
        $number = "1";
        

        $project = $this->em
            ->getRepository('AppBundle:Project')
            ->create($customer,$name,$number,$approver,$company);
            
        $nameTest = "project 1";
        $isDuplicate = $this->em
            ->getRepository('AppBundle:Project')
            ->isDuplicateName($nameTest);        
            
        $this->assertTrue($isDuplicate);
    }
    public function testEdit()
    {
        $user = $this->em->getRepository('AppBundle:User')
            ->create($this->um, "Test", "User", "test@email.com", "test123", "accountant@email.com");
        $user2 = $this->em->getRepository('AppBundle:User')
            ->create($this->um, "Test2", "User2", "test2@email.com", "test123", "accountant2@email.com");
        $company = new Company();  
        $company->setName('test company');
        $this->em->persist($company);        
        $dateTime = new \DateTime();    

        
        
        // Fields for Project
        $approver = $this->em->getRepository('AppBundle:Employee')
            ->create($user, $company, ["accountant", "admin", "approver"], true);
        $name = "Project 1";
        $customer = "Customer 1";
        $number = "1";        

        $uApprover = $this->em->getRepository('AppBundle:Employee')
            ->create($user, $company, ["accountant", "admin", "approver"], true);
        $uName = "Project U";
        $uCustomer = "Customer U";
        $uNumber = "12";        

        $project = $this->em
            ->getRepository('AppBundle:Project')
            ->create($customer,$name,$number,$approver,$company);
                    
        $updatedProject = $this->em
            ->getRepository('AppBundle:Project')       
            ->edit($project->getId(),$uCustomer, $uName, $uNumber, $uApprover);
            
        $this->assertEquals($updatedProject->getName(),$uName);
        $this->assertEquals($updatedProject->getNumber(),$uNumber);
        $this->assertEquals($updatedProject->getApprover(),$uApprover);
    }

    public function testDelete()
    {
        $user = $this->em->getRepository('AppBundle:User')
            ->create($this->um, "Test", "User", "test@email.com", "test123", "accountant@email.com");
        $company = new Company();  
        $company->setName('test company');

        $this->em->persist($company);        

        $approver = $this->em->getRepository('AppBundle:Employee')
            ->create($user, $company, ["accountant", "admin", "approver"], true);

        // Fields for Project
        $name = "Project 1";
        $customer = "Customer 1";
        $number = "1";
        

        $project = $this->em
            ->getRepository('AppBundle:Project')
            ->create($customer,$name,$number,$approver,$company);
        $this->em
            ->getRepository('AppBundle:Project')
            ->delete($project->getId());
        $project = $this->em
            ->getRepository('AppBundle:Project')
            ->find($project->getId());     

        $this->assertFalse($project->getEnabled());
    }
    public function testFindAllActiveByCompany()
    {
        $user = $this->em->getRepository('AppBundle:User')
        ->create($this->um, "Test", "User", "test@email.com", "test123", "accountant@email.com");
        $company = new Company();  
        $company->setName('test company');
        $this->em->persist($company);        

        $company = new Company();  
        $company->setName('test company');
        $this->em->persist($company);

        $company2 = new Company();  
        $company2->setName('test company2');
        $this->em->persist($company2);



        $approver = $this->em->getRepository('AppBundle:Employee')
            ->create($user, $company, ["accountant", "admin", "approver"], true);

        $project = $this->createDummyProject($company,$approver);
        $project2 = $this->createDummyProject($company2,$approver);
        $project3 = $this->createDummyProject($company,$approver);

        $projects = $this->em->getRepository('AppBundle:Project')
            ->findAllActiveByCompany($company);
        $allProjects = $this->em->getRepository('AppBundle:Project')
            ->findAll();

        $this->assertNotContains($project2,$projects);
        $this->assertEquals(2, count($projects));
        $this->assertEquals(3, count($allProjects));

    }

    public function createDummyProject($company, $approver)
    {        
        // Fields for Project
        $name = "Project";
        $customer = "Customer";
        $number = "1";        
        $project = $this->em
            ->getRepository('AppBundle:Project')
            ->create($customer,$name,$number,$approver,$company);
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