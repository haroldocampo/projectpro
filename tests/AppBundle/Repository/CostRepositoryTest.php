<?php
namespace Tests\AppBundle\Repository;

use AppBundle\Entity\Cost;
use AppBundle\Entity\Company;
use AppBundle\Entity\Project;
use AppBundle\Entity\DisabledExpenseType;
use Tests\AppBundle\DatabasePrimer;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CostRepositoryTest extends KernelTestCase
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

    public function testCreate()
    {            
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
        $costs = $this->em
            ->getRepository('AppBundle:Cost')
            ->findAll();        
        $this->assertContains($cost,$costs);
    }
    public function testDelete()
    {
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
        $this->em
        ->getRepository('AppBundle:Cost')
        ->delete($cost->getId()); 
        $costs = $this->em
            ->getRepository('AppBundle:Cost')
            ->findAll();   
        $this->assertEmpty($costs);
    }
    public function testToggleCostEnable(){
        $project = new Project(); 
        $project->setName('proj')
                ->setNumber('123');
        $this->em->persist($project);
        $codeNumber = "1";
        $expenseType = "M";
        $description= "hello";
        $budgetAmount = 1.0;

        $isAllExpenseTypes = true;
        $isAllProjects = true;

        $cost = $this->em
            ->getRepository('AppBundle:Cost')
            ->create($project, $codeNumber, $expenseType, $description, $budgetAmount);                                    

            
        $this->em
            ->getRepository('AppBundle:Cost')
            ->toggleCost($cost, true, $isAllExpenseTypes, $isAllProjects);

        $eTypes = $this->em
            ->getRepository('AppBundle:DisabledExpenseType')
            ->findAll();

        $this->assertTrue($cost->getEnabled());
        $this->assertEmpty($eTypes);
    }
    public function testToggleCostDisable(){
        $project = new Project(); 
        $project->setName('proj')
                ->setNumber('123');
        $this->em->persist($project);
        $codeNumber = "1";
        $expenseType = "M";
        $description= "hello";
        $budgetAmount = 1.0;

        $isAllExpenseTypes = true;
        $isAllProjects = true;

        $cost = $this->em
            ->getRepository('AppBundle:Cost')
            ->create($project, $codeNumber, $expenseType, $description, $budgetAmount);                                    

            
        $this->em
            ->getRepository('AppBundle:Cost')
            ->toggleCost($cost, false, $isAllExpenseTypes, $isAllProjects);

        $eTypes = $this->em
            ->getRepository('AppBundle:DisabledExpenseType')
            ->findAll();

        $this->assertFalse($cost->getEnabled());
        $this->assertEquals(1,count($eTypes));
    }
    public function testToggleCostEnableAllByProject(){
        $project = new Project(); 
        $project->setName('proj')
                ->setNumber('123');
        $project2 = new Project(); 
        $project2->setName('proj')
                ->setNumber('123');
        $this->em->persist($project);
        $this->em->persist($project2);
        $this->em->flush();        
        $expenseType = "M";
        $description= "hello";
        $budgetAmount = 1.0;

        $isAllExpenseTypes = true;
        $isAllProjects = false;

        $cost = $this->em
            ->getRepository('AppBundle:Cost')
            ->create($project, "1", $expenseType, $description, $budgetAmount);                                    
        $cost2 = $this->em
            ->getRepository('AppBundle:Cost')
            ->create($project, "2", $expenseType, $description, $budgetAmount);                                            
        $this->em
            ->getRepository('AppBundle:Cost')
            ->toggleCost($cost, true, $isAllExpenseTypes, $isAllExpenseTypes);

        $eTypes = $this->em
            ->getRepository('AppBundle:DisabledExpenseType')
            ->findAll();        
        $this->assertTrue($cost->getEnabled());
        $this->assertTrue($cost2->getEnabled());        
    }
    public function testToggleCostDisableAllByProject(){
        $project = new Project(); 
        $project->setName('proj')
                ->setNumber('123');
        $project2 = new Project(); 
        $project2->setName('proj')
                ->setNumber('123');
        $this->em->persist($project);
        $this->em->persist($project2);
        $this->em->flush();        
        $expenseType = "M";
        $description= "hello";
        $budgetAmount = 1.0;

        $isAllExpenseTypes = true;
        $isAllProjects = false;

        $cost = $this->em
            ->getRepository('AppBundle:Cost')
            ->create($project, "1", $expenseType, $description, $budgetAmount);                                    
        $cost2 = $this->em
            ->getRepository('AppBundle:Cost')
            ->create($project, "2", $expenseType, $description, $budgetAmount);                                    
        $cost3 = $this->em
            ->getRepository('AppBundle:Cost')
            ->create($project2, "3", $expenseType, $description, $budgetAmount);                                    
            
        $this->em
            ->getRepository('AppBundle:Cost')
            ->toggleCost($cost, false, $isAllExpenseTypes, $isAllProjects);

        $eTypes = $this->em
            ->getRepository('AppBundle:DisabledExpenseType')
            ->findAll();        
        $this->assertFalse($cost->getEnabled());
        $this->assertFalse($cost2->getEnabled());
        $this->assertTrue($cost3->getEnabled());
        
    }   
    public function testToggleCostEnableAllByCompany(){
        $project = new Project(); 
        $project->setName('proj')
                ->setNumber('123');
        $project2 = new Project(); 
        $project2->setName('proj')
                ->setNumber('123');
        $this->em->persist($project);
        $this->em->persist($project2);
        $this->em->flush();        
        $expenseType = "M";
        $description= "hello";
        $budgetAmount = 1.0;

        $isAllExpenseTypes = true;
        $isAllProjects = true;

        $cost = $this->em
            ->getRepository('AppBundle:Cost')
            ->create($project, "1", $expenseType, $description, $budgetAmount);                                            
        $cost2 = $this->em
            ->getRepository('AppBundle:Cost')
            ->create($project, "2", $expenseType, $description, $budgetAmount);                                        
        $cost3 = $this->em
            ->getRepository('AppBundle:Cost')
            ->create($project2, "3", $expenseType, $description, $budgetAmount);                                                
        $this->em
            ->getRepository('AppBundle:Cost')
            ->toggleCost($cost, true, $isAllExpenseTypes, $isAllProjects);

        $eTypes = $this->em
            ->getRepository('AppBundle:DisabledExpenseType')
            ->findAll();        
        $this->assertTrue($cost->getEnabled());
        $this->assertTrue($cost2->getEnabled());
        $this->assertTrue($cost3->getEnabled());
    }
    public function testToggleCostDisableAllByCompany(){
        $project = new Project(); 
        $project->setName('proj')
                ->setNumber('123');
        $project2 = new Project(); 
        $project2->setName('proj')
                ->setNumber('123');
        $this->em->persist($project);
        $this->em->persist($project2);
        $this->em->flush();        
        $expenseType = "M";
        $description= "hello";
        $budgetAmount = 1.0;

        $isAllExpenseTypes = true;
        $isAllProjects = true;

        $cost = $this->em
            ->getRepository('AppBundle:Cost')
            ->create($project, "1", $expenseType, $description, $budgetAmount);                                    
        $cost2 = $this->em
            ->getRepository('AppBundle:Cost')
            ->create($project2, "2", $expenseType, $description, $budgetAmount);                                    
        $cost3 = $this->em
            ->getRepository('AppBundle:Cost')
            ->create($project2, "3", $expenseType, $description, $budgetAmount);                                    
            
        $this->em
            ->getRepository('AppBundle:Cost')
            ->toggleCost($cost, false, $isAllExpenseTypes, $isAllProjects);

        $eTypes = $this->em
            ->getRepository('AppBundle:DisabledExpenseType')
            ->findAll();        
        $this->assertFalse($cost->getEnabled());
        $this->assertFalse($cost2->getEnabled());
        $this->assertFalse($cost3->getEnabled());
        $this->assertEquals(1, count($eTypes));
    }   


    // public function testToggleEnableExpenseTypes()
    // {
    //     // Setup Company and Project to add Costs for
    //     $company = new Company();
    //     $company->setName("Test Company");
    //     $this->em->persist($company);
        

    //     $project = new Project(); 
    //     $project->setName('proj')
    //             ->setNumber('123');
    //     $this->em->persist($project);

    //     $this->em->flush();

    //     // Create Cost
    //     $codeNumber = "1";
    //     $expenseType = "192";
    //     $description= "hello";
    //     $budgetAmount = 1.0;

    //     $cost = $this->em
    //         ->getRepository('AppBundle:Cost')
    //         ->create($project, $codeNumber, $expenseType, $description, $budgetAmount);

    //     //Toggle Action
    //     $action = 'enable';

    //     //TODO put future disabled expense type repo toggle here
    //     $expenseTypes = $this->getDoctrine()
    //             ->getRepository('AppBundle:DisabledExpenseType')
    //             ->findBy(['company' => $company, 'name' => $expenseType]);
    //     $this->assertEmpty($expenseTypes);
    // }

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