<?php
/**
 * Created by PhpStorm.
 * User: marks
 * Date: 10/7/2017
 * Time: 12:05 PM
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Company;
use AppBundle\Entity\Project;
use Doctrine\ORM\EntityRepository;

class ProjectRepository extends EntityRepository
{
    /**
     * @param Company $company
     * @return array
     */
    public function findAllActiveByCompany(Company $company) {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('project')
            ->from('AppBundle:Project', 'project')
            ->where('project.company = :company')
            ->setParameter('company', $company)
            ->andWhere('project.enabled = :enabled')
            ->setParameter('enabled', true);

        return $qb->getQuery()->getResult();
    }
    public function create($customer, $name, $number, $approver,$company){
        $em = $this->getEntityManager();
        $project = new Project();
        $project->setName($name);
        $project->setCustomer($customer);
        $project->setNumber($number);
        $project->setApprover($approver);
        $project->setCompany($company);
        $em->persist($project);
        $em->flush();
        return $project;
    }
    public function edit($projectId, $customer, $name, $number, $approver){
        $em = $this->getEntityManager();
        $project = $this->find($projectId);
        $project->setName($name);
        $project->setCustomer($customer);
        $project->setNumber($number);
        $project->setApprover($approver);
        $em->merge($project);
        $em->flush();
        return $project;
    }
    public function delete($projectId){
        $em = $this->getEntityManager();

        $project = $this->find($projectId);
        if(!$project)
            return null;
        

        $project->setEnabled(false);
        $em->flush();
        return true;
    }
    public function isDuplicateName($name){    
        $project = $this->findBy(['name' => $name]);       
        
        $qb = $this->_em->createQueryBuilder();
        $qb->select('project')
            ->from('AppBundle:Project', 'project')
            ->where('upper(project.name) = upper(:name)')
            ->setParameter('name', $name);        

        $project = $qb->getQuery()->getResult();
        
        if(count($project))
            return true;
        return false;
    }
}