<?php
namespace AppBundle\Repository;

use AppBundle\Entity\Employee;
use AppBundle\Entity\PaymentType;
use AppBundle\Entity\EmployeePaymentType;
use Doctrine\ORM\EntityRepository;

class EmployeePaymentTypeRepository extends EntityRepository
{    
    public function create($company,$employeeId,$name)
    {
        $em = $this->getEntityManager();

        $paymentTypes = $this->getEntityManager()
            ->getRepository('AppBundle:PaymentType')
                ->findBy(['company' => $company, 'name' => $name]);
        //Make sure payment type is enabled and exists
        if (count($paymentTypes) > 0) {
            $paymentType = $paymentTypes[0];
            $paymentType->setEnabled = true;
        } else {
            $paymentType = new PaymentType();
            $paymentType->setCompany($company)
                    ->setName($name);
            $em->persist($paymentType);

            $em->flush();
        }

        $employeePaymentType = new \AppBundle\Entity\EmployeePaymentType();
        $employee = $this->getEntityManager()
            ->getRepository('AppBundle:Employee')
                ->find($employeeId);

        $dupeCheck = $this->findBy(['employee' => $employee, 'paymentType' => $paymentType]);

        $employeePaymentType->setEmployee($employee)
                ->setPaymentType($paymentType)
                ->setEnabled(true);

        if (!$dupeCheck) {
            $em->persist($employeePaymentType);
        }
        $em->flush();
        return $employeePaymentType;
    }  
    
    public function delete($company,$employeeId, $name)
    {
        $em = $this->getEntityManager();

        $employee = $this->getEntityManager()
            ->getRepository('AppBundle:Employee')
                ->find($employeeId);

        $paymentTypes = $this->getEntityManager()
            ->getRepository('AppBundle:PaymentType')
                ->findBy(['company' => $company, 'name' => $name]);

        if(!$paymentTypes)
            return null;        

        foreach ($paymentTypes as $paymentType) {
            $employeePaymentTypes = $this->findBy(['employee' => $employee, 'paymentType' => $paymentType]);

            foreach ($employeePaymentTypes as $item) {
                $em->remove($item);
            }
        }

        $em->flush();
        return true;
    }
   
    
}