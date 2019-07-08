<?php
/**
 * Created by PhpStorm.
 * User: marks
 * Date: 10/7/2017
 * Time: 12:05 PM
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Company;
use Doctrine\ORM\EntityRepository;

class CompanyRepository extends EntityRepository
{
    public function create($name){
        $em = $this->getEntityManager();
        $company = new Company();
        $company->setName($name);        
        $em->persist($company);
        $em->flush();
        return $company;
    }
    public function edit($companyId, $name){
        $this->find($companyId);        
        $company = $this->find($companyId);  
        if(!$company)
            return null;      
        $em = $this->getEntityManager();
        $company->setName($name);
        $em->persist($company);
        $em->flush();
        return $company;
    }    
    public function listByUser($user){
        // $employments = $user->getEmplosyments();
        $em = $this->getEntityManager();
        $employments = $em->getRepository('AppBundle:Employee')
            ->findBy(['user'=>$user]);

        $companies = [];                

        foreach ($employments as $employment) {
            if ($employment->getEnabled()) {
                array_push($companies, [
                    'companyId' => $employment->getCompany()->getId(),
                    'name' => $employment->getCompany()->getName(),
                    'employeeId' => $employment->getId()
                ]);
            }
        }
        return $companies;
    }
}