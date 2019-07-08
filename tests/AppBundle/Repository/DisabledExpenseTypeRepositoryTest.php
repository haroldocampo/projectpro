<?php
namespace Tests\AppBundle\Repository;

use AppBundle\Entity\Company;
use AppBundle\Entity\Project;
use AppBundle\Entity\Cost;
use AppBundle\Entity\DisabledExpenseType;
use Tests\AppBundle\DatabasePrimer;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DisabledExpenseTypeRepositoryTest extends KernelTestCase
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
        
    }
    public function testToggleExpenseTypeEnable(){

        $company = new Company();
        $company->setName('test company');
        $name = "Cash";
        $this->em->persist($company);
        $this->em->flush();
        
        $cost = $this->dummyCost($company, 'G');
        $eType = $this->em
            ->getRepository('AppBundle:DisabledExpenseType')
            ->toggleDisabled($company, $cost->getExpenseType(), false);
        
        $eTypes = $this->em
            ->getRepository('AppBundle:DisabledExpenseType')
            ->findAll();

        $this->assertContains($eType,$eTypes);
    }
    public function testToggleExpenseTypeDisable(){

        $company = new Company();
        $company->setName('test company');
        $name = "Cash";
        $this->em->persist($company);
        $this->em->flush();
        
        $cost = $this->dummyCost($company, 'G');
        $eType = $this->em
            ->getRepository('AppBundle:DisabledExpenseType')
            ->toggleDisabled($company, $cost->getExpenseType(), 'disable');
        $eType = $this->em
            ->getRepository('AppBundle:DisabledExpenseType')
            ->toggleDisabled($company, $cost->getExpenseType(), 'enable');
        
        $eTypes = $this->em
            ->getRepository('AppBundle:DisabledExpenseType')
            ->findAll();

        $this->assertEmpty($eTypes);
    }

    public function dummyCost($company, $expenseType){


        $project = new Project(); 
        $project->setName('proj')
                ->setNumber('123');
        $this->em->persist($project);
        $codeNumber = "1";
        $description= "hello";
        $budgetAmount = 10.0;
        
        $cost = $this->em
            ->getRepository('AppBundle:Cost')
            ->create($project, $codeNumber, $expenseType, $description, $budgetAmount);    
        return $cost;
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
    parent::tearDown();

    $this->em->close();

    $this->em=null;

    gc_collect_cycles();
    }
}