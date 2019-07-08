<?php
namespace AppBundle\Repository;

use AppBundle\Entity\Cost;
use AppBundle\Entity\Project;
use Doctrine\ORM\EntityRepository;

class CostRepository extends EntityRepository
{

    /**
     * @param Project $project
     * @param string $codeNumber
     * @param string $expenseType
     * @param string $description
     * @param float $budgetAmount 
     * @return array
     */
    public function create($project, $codeNumber, $expenseType, $description, $budgetAmount)
    {
        $em = $this->getEntityManager();
        $cost = new Cost();
        $cost->setProject($project)
        ->setCodeNumber($codeNumber)
        ->setExpenseType($expenseType)
        ->setDescription($description)
        ->setBudgetAmount($budgetAmount);
        $em->persist($cost);
        $em->flush();
        return $cost;
    }

    /**
     * @param Project $project
     * @param string $codeNumber
     * @param string $expenseType
     * @param string $description
     * @param float $budgetAmount 
     * @return array
     */
    public function update($id, $codeNumber, $expenseType, $description, $budgetAmount)
    {
        $cost = $this->find($id);
        if(!$cost)
            return null;            
        
        
        //if(count($cost->getPurchaseItems()) > 0){
        //    return false; // Return false if the cost code has purchase items tied down
        //}
        
        // Update Cost Code

        $cost->setCodeNumber($codeNumber)
        ->setExpenseType($expenseType)
        ->setDescription($description)
        ->setBudgetAmount($budgetAmount);

        $em = $this->getEntityManager();
        $em->flush();
        return $cost;
    }
    
    public function findByCompany($company)
    {
        $projects = $this->getEntityManager()
            ->getRepository('AppBundle:Project')
            ->findBy(['company' => $company]);
        $resultCosts = array();
        foreach ($projects as $project) {
            $costs = $project->getCosts();
            foreach ($costs as $cost) {
                $resultCosts[] = $cost;
            }
        }        
        return $resultCosts;
    }
    public function delete($costId)
    {
        $cost = $this->find($costId);
        if(!$cost)
            return null;            
        
        
        if(count($cost->getPurchaseItems()) > 0){
            return false; // Return false if the cost code has purchase items tied down
        }

        $em = $this->getEntityManager();
        $em->remove($cost);
        $em->flush();
        return true;
    }

    public function toggleCost($costId ,$action, $isAllExpenseTypes, $isAllProjects){

        $em = $this->getEntityManager();        
        $cost = $this->find($costId);
        if(!$cost)
            return null;
        
        $cost->setEnabled($action);

        if ($isAllExpenseTypes) {
            $costsWithExpenseType = null;            
            if (!$isAllProjects) {
                $costsWithExpenseType = $this->findBy(['project' => $cost->getProject(), 'expenseType' => $cost->getExpenseType()]);
            } else {       
                         
                $costsWithExpenseType = $this->findBy(['expenseType' => $cost->getExpenseType()]);                                                
                $em->getRepository('AppBundle:DisabledExpenseType')
                ->toggleDisabled($cost->getProject()->getCompany(), $cost->getExpenseType(), $action);
            }            
            foreach ($costsWithExpenseType as $costWET) {                
                $costWET->setEnabled($action);
            }
        }

        $em->flush();
        return $cost;
    }
}