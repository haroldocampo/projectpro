<?php
namespace AppBundle\Repository;

use AppBundle\Entity\Company;
use AppBundle\Entity\Vendor;
use Doctrine\ORM\EntityRepository;

class VendorRepository extends EntityRepository
{    
   
    public function create($company, $name) {
        $em = $this->getEntityManager();
        $vendor = new Vendor();
        $vendor->setCompany($company)
        ->setName($name);
        $em->persist($vendor);
        $em->flush();
        return $vendor;
    }
    public function isUniqueName($id,$name){
        $qb = $this->_em->createQueryBuilder();
        $qb->select('vendor')
        ->from('AppBundle:Vendor', 'vendor')
        ->where('vendor.id != :id')
        ->setParameter('id', $id)
        ->andWhere('vendor.name = :name')
        ->setParameter('name',$name);
        $vendors =  $qb->getQuery()->getResult();      
        $vendor  = $this->find($id);        
        if($name == $vendor->getName())
            return 'same';
        else if(isset($vendors[0]))
            return 'exists';
        return 'unique';
    }

    public function merge($toMergeId, $finalMergedId) {
        $em = $this->getEntityManager();
        $vendor = $em->getRepository('AppBundle:Vendor')
            ->find($toMergeId);
        $vendor->setMergeId($finalMergedId);

        $nestedVendors = $this->findBy(['mergeId' => $toMergeId]);
        foreach($nestedVendors as $vendor){
            $vendor->setMergeId($finalMergedId);
        }          
        $em->persist($vendor);      
        $em->flush();
        $vendor = $em->getRepository('AppBundle:Vendor')
            ->find($finalMergedId);
        return $vendor;
    }

    public function editName($id,$name){
        $em = $this->getEntityManager();
        $vendor = $em->getRepository('AppBundle:Vendor')
            ->find($id);
        $vendor->setName($name);
        $em->flush();
        return $vendor;
    }
    public function delete($id) {
        $em = $this->getEntityManager();        
        $vendor = $this->find($id);
        $em->remove($vendor);        
        $em->flush();        
        return true;
    }
    public function findAllUnmergedByCompany($company){
        $vendors = $this->findBy(['mergeId' => null,'company'=>$company],['name'=>'asc']);
        return $vendors;
    }
    
}