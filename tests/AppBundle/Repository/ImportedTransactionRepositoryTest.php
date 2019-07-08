<?php
namespace Tests\AppBundle\Repository;

use AppBundle\Entity\ImportedTransaction;
use AppBundle\Entity\Company;
use AppBundle\Entity\PaymentType;
use AppBundle\Entity\Project;
use AppBundle\Entity\Purchase;
use Tests\AppBundle\DatabasePrimer;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ImportedTransactionRepositoryTest extends KernelTestCase
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
        
        $company = new Company();  
        $company->setName('test company');
        $this->em->persist($company);        
        $dateTime = new \DateTime();        
        $description = "this is a desc";
        $accountNumber = "1234";
        $floatAmount= 50.00;
        
        $transaction = $this->em
            ->getRepository('AppBundle:ImportedTransaction')
            ->create($dateTime, $company, $description, $accountNumber, $floatAmount);
            
        $transactions = $this->em
            ->getRepository('AppBundle:ImportedTransaction')
            ->findAll();        
            
        $this->assertContains($transaction,$transactions);
    } 
    public function testGetMatchedTransactions()
    {                    
        
        $company = new Company();  
        $company->setName('test company');
        $this->em->persist($company);     

        $dateTime = new \DateTime();        
        $description = "this is a desc";
        $accountNumber = "1234";
        $floatAmount= -50.00;
        
        $transaction = $this->em
            ->getRepository('AppBundle:ImportedTransaction')
            ->create($dateTime, $company, $description, $accountNumber, $floatAmount);
            
        $transactions = $this->em
            ->getRepository('AppBundle:ImportedTransaction')
            ->getMatchedTransactions($company,50.0);   
            
        $this->assertEquals($floatAmount,$transactions[0]->getAmount());
    } 
    public function testGetMatchedTransactionsWithTwoSameAbs()
    {                    
        
        $company = new Company();  
        $company->setName('test company');
        $this->em->persist($company);     

        $dateTime = new \DateTime();        
        $description = "this is a desc";
        $accountNumber = "1234";
        $floatAmount= -50.00;
        
        $transaction = $this->em
            ->getRepository('AppBundle:ImportedTransaction')
            ->create($dateTime, $company, $description, $accountNumber, $floatAmount);
        $transaction2 = $this->em
            ->getRepository('AppBundle:ImportedTransaction')
            ->create($dateTime, $company, $description, $accountNumber, 50.00);
        $transactions = $this->em
            ->getRepository('AppBundle:ImportedTransaction')
            ->getMatchedTransactions($company,-50.0);
            
        $this->assertEquals(2,count($transactions));
    }    
    public function testGetMatchedTransactionsWithMatchPurchase()
    {                    
        
        $company = new Company();  
        $company->setName('test company');
        $this->em->persist($company);             

        $dateTime = new \DateTime();        
        $description = "this is a desc";
        $accountNumber = "1234";
        $floatAmount= -50.00;
        
        $transaction = $this->em
            ->getRepository('AppBundle:ImportedTransaction')
            ->create($dateTime, $company, $description, $accountNumber, $floatAmount);
        $purchase = $this->dummyPurchase($company);
        $transaction->setMatchedPurchase($purchase);

        $this->em->persist($transaction);        
        $this->em->flush();

        $transactions = $this->em
            ->getRepository('AppBundle:ImportedTransaction')
            ->getMatchedTransactions($company, -50);
            
        $this->assertEmpty($transactions);
    }   
    public function testGetMatchedTransactionsSameAbsDifferentCompany()
    {                    
        
        $company = new Company();  
        $company->setName('test company');

        $company2 = new Company();  
        $company2->setName('test company2');
        $this->em->persist($company);             
        $this->em->persist($company2);             
        $dateTime = new \DateTime();        
        $description = "this is a desc";
        $accountNumber = "1234";
        $floatAmount= -50.00;
        
        $transaction = $this->em
            ->getRepository('AppBundle:ImportedTransaction')
            ->create($dateTime, $company, $description, $accountNumber, $floatAmount);

        $transaction2 = $this->em
            ->getRepository('AppBundle:ImportedTransaction')
            ->create($dateTime, $company2, $description, $accountNumber, $floatAmount);

                       

        $transactions = $this->em
            ->getRepository('AppBundle:ImportedTransaction')
            ->getMatchedTransactions($company, -50);
            
        $this->assertContains($transaction, $transactions);
        $this->assertNotContains($transaction2, $transactions);
    }
    public function testDelete()
    {
        $company = new Company();  
        $company->setName('test company');
        $this->em->persist($company);        
        $dateTime = new \DateTime();        
        $description = "this is a desc";
        $accountNumber = "1234";
        $floatAmount= 50.00;
        
        $transaction = $this->em
            ->getRepository('AppBundle:ImportedTransaction')
            ->create($dateTime, $company, $description, $accountNumber, $floatAmount);        

        $this->em->getRepository('AppBundle:ImportedTransaction')->delete($transaction->getId());
        $transactions = $this->em
            ->getRepository('AppBundle:ImportedTransaction')
            ->findAll();     
        $this->assertEmpty($transactions);
    }
    public function testDeleteDuplicates()
    {
        $company = new Company();  
        $company->setName('test company');
        $this->em->persist($company);        
        $dateTime = new \DateTime();        
        $description = "this is a desc";
        $accountNumber = "1234";
        $floatAmount= 50.00;
        
        $transaction = $this->em
            ->getRepository('AppBundle:ImportedTransaction')
            ->create($dateTime, $company, $description, $accountNumber, $floatAmount);        
        $duplicate = $this->em
            ->getRepository('AppBundle:ImportedTransaction')
            ->create($dateTime, $company, $description, $accountNumber, $floatAmount);        
        $duplicate2 = $this->em
            ->getRepository('AppBundle:ImportedTransaction')
            ->create($dateTime, $company, $description, $accountNumber, $floatAmount);        
        $notDuplicate = $this->em
        ->getRepository('AppBundle:ImportedTransaction')
        ->create($dateTime, $company, $description, 'hello', 30.00);                        
        
        $this->em->getRepository('AppBundle:ImportedTransaction')->deleteDuplicates($company);
        $transactions = $this->em
            ->getRepository('AppBundle:ImportedTransaction')
            ->findAll();                 
        $this->assertEquals(2,count($transactions));
    }
    public function dummyPurchase($company)
    {
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
        return $purchase;
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