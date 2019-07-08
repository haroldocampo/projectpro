<?php
namespace Tests\AppBundle\Repository;

use AppBundle\Entity\Vendor;
use AppBundle\Entity\Company;
use AppBundle\Entity\Project;
use AppBundle\Entity\DisabledExpenseType;
use Tests\AppBundle\DatabasePrimer;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class VendorRepositoryTest extends KernelTestCase
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
        //Vendor Parameters
        $company = new Company(); 
        $company->setName('comp');
        $this->em->persist($company);
        $this->em->flush();
        $name = "vend";        

        $vendor = $this->em
            ->getRepository('AppBundle:Vendor')
            ->create($company,$name);
        $vendors = $this->em
            ->getRepository('AppBundle:Vendor')
            ->findAll();        
        $this->assertContains($vendor,$vendors);
    }
    public function testMerge()
    { 
        //Vendor Parameters         
        $company = new Company(); 
        $company->setName('comp');
        $this->em->persist($company);
        $this->em->flush();
        $name = "vend";        

        $vendor = $this->em
            ->getRepository('AppBundle:Vendor')
            ->create($company,'vend');
        $vendor2 = $this->em
            ->getRepository('AppBundle:Vendor')
            ->create($company,'vend2');        
        $this->em
            ->getRepository('AppBundle:Vendor')
            ->merge($vendor2->getId(),$vendor->getId());        
        $this->assertEquals($vendor->getId(), $vendor2->getMergeId());        
    }    
    public function testNestedMerge()
    {
        //Vendor Parameters
        $company = new Company(); 
        $company->setName('comp');
        $this->em->persist($company);
        $this->em->flush();
        $name = "vend";        

        $vendor = $this->em
            ->getRepository('AppBundle:Vendor')
            ->create($company,$name);
        $vendor2 = $this->em
            ->getRepository('AppBundle:Vendor')
            ->create($company,$name);
        $vendor3 = $this->em
            ->getRepository('AppBundle:Vendor')
            ->create($company,$name);
        $this->em
            ->getRepository('AppBundle:Vendor')
            ->merge($vendor2->getId(),$vendor->getId());
        $this->em  
            ->getRepository('AppBundle:Vendor')
            ->merge($vendor3->getId(),$vendor->getId());
        $this->assertEquals($vendor->getId(), $vendor2->getMergeId()); 
        $this->assertEquals($vendor->getId(), $vendor3->getMergeId()); 

    }
    public function testFindUnmerged()
    {
        //Vendor Parameters         
        $company = new Company(); 
        $company->setName('comp');
        $this->em->persist($company);

        $company2 = new Company(); 
        $company2->setName('comp2');
        $this->em->persist($company2);
        $this->em->flush();
        $name = "vend";
        

        $vendor = $this->em
            ->getRepository('AppBundle:Vendor')
            ->create($company,$name);
        $vendor2 = $this->em
            ->getRepository('AppBundle:Vendor')
            ->create($company,$name);
        $vendor3 = $this->em
            ->getRepository('AppBundle:Vendor')
            ->create($company,$name);

        $vendor3 = $this->em
            ->getRepository('AppBundle:Vendor')
            ->merge($vendor3->getId(),$vendor2->getId());

        $vendors = $this->em
            ->getRepository('AppBundle:Vendor')
            ->findAllUnmergedByCompany($company);        
        $this->assertContains($vendor,$vendors);
        // $this->assertNotContains($vendor2,$vendors);
        $this->assertContains($vendor3,$vendors);
    }

    public function testEditName()
    {
        //Vendor Parameters         
        $company = new Company(); 
        $company->setName('comp');
        $this->em->persist($company);
        $this->em->flush();
        $name = "vend";
        $newName = "vendNew";


        $vendor = $this->em
            ->getRepository('AppBundle:Vendor')
            ->create($company,$name);
        $vendor = $this->em
            ->getRepository('AppBundle:Vendor')
            ->editName($vendor->getId(),$newName);

        $this->assertEquals($newName, $vendor->getName());
    }
    
    public function testDelete()
    {        
        //Vendor Parameters         
        $company = new Company(); 
        $company->setName('comp');
        $this->em->persist($company);
        $this->em->flush();
        $name = "vend";


        $vendor = $this->em
            ->getRepository('AppBundle:Vendor')
            ->create($company, $name);            
        $this->em
        ->getRepository('AppBundle:Vendor')
        ->delete($vendor->getId()); 
        $vendors = $this->em
            ->getRepository('AppBundle:Vendor')
            ->findAll();   
        $this->assertEmpty($vendors);
    }
    public function testIsUniqueNameUnique()
    {
        //Vendor Parameters         
        $company = new Company(); 
        $company->setName('comp');
        $this->em->persist($company);
        $this->em->flush();        


        $vendor = $this->em
            ->getRepository('AppBundle:Vendor')
            ->create($company, 'vend');    
        $vendor2 = $this->em
            ->getRepository('AppBundle:Vendor')
            ->create($company, 'name');    
        $isUnique = $this->em
            ->getRepository('AppBundle:Vendor')
            ->isUniqueName($vendor->getId(), 'jabert');

        $this->assertEquals('unique',$isUnique);
    }
    public function testIsUniqueNameExists()
    {
        //Vendor Parameters         
        $company = new Company(); 
        $company->setName('comp');
        $this->em->persist($company);
        $this->em->flush();        


        $vendor = $this->em
            ->getRepository('AppBundle:Vendor')
            ->create($company, 'vend');    
        $vendor2 = $this->em
            ->getRepository('AppBundle:Vendor')
            ->create($company, 'name');    
        $isUnique = $this->em
            ->getRepository('AppBundle:Vendor')
            ->isUniqueName($vendor->getId(), 'name');

        $this->assertEquals('exists',$isUnique);
    }
    public function testIsUniqueNameSame()
    {
        //Vendor Parameters         
        $company = new Company(); 
        $company->setName('comp');
        $this->em->persist($company);
        $this->em->flush();        


        $vendor = $this->em
            ->getRepository('AppBundle:Vendor')
            ->create($company, 'vend');    
        $vendor2 = $this->em
            ->getRepository('AppBundle:Vendor')
            ->create($company, 'name');    
        $isUnique = $this->em
            ->getRepository('AppBundle:Vendor')
            ->isUniqueName($vendor->getId(), 'vend');

        $this->assertEquals('same',$isUnique);
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