<?php
namespace AppBundle\Repository;

use AppBundle\Entity\PaymentType;
use AppBundle\Entity\DisabledExpenseType;
use Doctrine\ORM\EntityRepository;

class DisabledExpenseTypeRepository extends EntityRepository
{    
   
    public function toggleDisabled($company, $expenseType, $action) {
        $em = $this->getEntityManager();
        
        $et = $this->findOneBy(['company' => $company, 'name' => $expenseType]);                
        if ($action) {            
            if (!isset($et)) {
                return;
            }
            $em->remove($et);
            $em->flush();
        } else {
            
            if (isset($et)) {
                return;
            }
            
            $et = new DisabledExpenseType();
            $et->setCompany($company)
                ->setName($expenseType);
            $em->persist($et);
            $em->flush();
            return $et;
        }
    }
    
    
}