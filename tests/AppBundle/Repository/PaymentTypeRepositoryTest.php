<?php
namespace Tests\AppBundle\Repository;

use AppBundle\Entity\Company;
use AppBundle\Entity\PaymentType;
use Tests\AppBundle\DatabasePrimer;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PaymentTypeRepositoryTest extends KernelTestCase
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

    public function testCreatePaymentType()
    {
        $company = new Company();
        $company->setName('test company');
        $name = "Cash";
        $this->em->persist($company);
        $this->em->flush();
        $paymentType = $this->em
            ->getRepository('AppBundle:PaymentType')
            ->create($company,$name);
        $paymentTypes = $this->em
            ->getRepository('AppBundle:PaymentType')
            ->findAll();
        $this->assertContains($paymentType,$paymentTypes);
    }

    public function testDeletePaymentType()
    {
        $company = new Company();
        $company->setName('test company');
        $name = "Cash";
        $this->em->persist($company);
        $this->em->flush();
        $paymentType = $this->em
            ->getRepository('AppBundle:PaymentType')
            ->create($company,$name);        
        $this->em
        ->getRepository('AppBundle:PaymentType')
        ->delete($paymentType->getId());
        $paymentTypes = $this->em
            ->getRepository('AppBundle:PaymentType')
            ->findBy(array('enabled'=>1));
            
        $this->assertEmpty($paymentTypes);
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