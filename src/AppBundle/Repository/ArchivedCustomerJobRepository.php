<?php
namespace AppBundle\Repository;

use AppBundle\Entity\PaymentType;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\ArchivedCustomerJob;

class ArchivedCustomerJobRepository extends EntityRepository
{

    public function findByCompany($company)
    {
        $customerJobs = $this->getEntityManager()
            ->getRepository('AppBundle:ArchivedCustomerJob')
            ->findBy(['company' => $company]);
        return $customerJobs;
    }

    public function add($company, $customerJobRepositoryName)
    {
        $em = $this->getEntityManager();

        $et = $this->findOneBy(['company' => $company, 'name' => $customerJobRepositoryName]);
        if (isset($et)) {
            return;
        }

        $et = new ArchivedCustomerJob();
        $et->setCompany($company)
            ->setName($customerJobRepositoryName);
        $em->persist($et);
        $em->flush();
        return $et;

    }


}