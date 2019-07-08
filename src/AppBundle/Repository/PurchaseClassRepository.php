<?php
namespace AppBundle\Repository;

use AppBundle\Entity\Company;
use AppBundle\Entity\PurchaseClass;
use Doctrine\ORM\EntityRepository;

class PurchaseClassRepository extends EntityRepository
{    
   
    public function create($company, $name)
    {
        $em = $this->getEntityManager();

        $purchaseClass = new PurchaseClass();
        $purchaseClass->setCompany($company)
            ->setName($name);

        $em->persist($purchaseClass);
        $em->flush();
        return $purchaseClass;
    }

    public function delete($id)
    {
        $em = $this->getEntityManager();

        $purchaseClass = $this->find($id);
        if(!$purchaseClass)
            return null;        
        $em->remove($purchaseClass);
        $em->flush();
        return true;
    }
    
    
}