<?php
/**
 * Created by PhpStorm.
 * User: marksegalle
 * Date: 27/09/2017
 * Time: 6:17 AM
 */

namespace AppBundle\Repository;


use AppBundle\Entity\Company;
use AppBundle\Entity\Employee;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;

class EmployeeRepository extends EntityRepository
{

    public function create($user, $company, $roles, $isDefaultAccountant = false)
    {
        $em = $this->getEntityManager();
        $employee = new Employee();
        $employee->setUser($user)
            ->setCompany($company);

        if ($isDefaultAccountant) {
            $employee->setIsDefaultAccountant(true);
        }

        foreach ($roles as $role) {
            if ($role == 'approver') {
                $employee->addRole(Employee::$ROLE_APPROVER);
            } elseif ($role == 'accountant') {
                $employee->addRole(Employee::$ROLE_ACCOUNTANT);
            } elseif ($role == 'admin') {
                $employee->addRole(Employee::$ROLE_ADMIN);
            }
        }

        $em->persist($employee);
        $em->flush();
        return $employee;
    }
    public function edit($employeeId, $firstName, $lastName)
    {
        $em = $this->getEntityManager();
        $employee = $this->find($employeeId);
        
        $user = $employee->getUser();

        $firstName = $firstName;
        if ($firstName) {
            $user->setFirstName($firstName);
        }
        $lastName = $lastName;
        if ($lastName) {
            $user->setLastName($lastName);
        }
        $em->flush();

        return $employee;
    }
    public function delete($employeeId)
    {
        $em = $this->getEntityManager();
        $employee = $this->find($employeeId);

        $employee->setEnabled(false);
        $em->flush();
        return true;
    }

    /**
     * @param string $role
     *
     * @return array
     */
    public function findByRole($role)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('u')
            ->from('AppBundle:Employee', 'u')
            ->where('u.roles LIKE :roles')
            ->setParameter('roles', '%"'.$role.'"%');

        return $qb->getQuery()->getResult();
    }
    /**
     * @param string $role
     *
     * @return array
     */
    public function findByCompanyRole($company,$role)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('u')
            ->from('AppBundle:Employee', 'u')
            ->where('u.roles LIKE :roles')
            ->setParameter('roles', '%"'.$role.'"%')
            ->andWhere('u.company = :company')
            ->setParameter('company', $company);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param User $user
     * @return array
     */
    public function findAdminsByUser($user)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('employee')
            ->from('AppBundle:Employee', 'employee')
            ->where('employee.user = :user')
            ->setParameter('user', $user)
            ->andWhere('employee.roles LIKE :role')
            ->setParameter('role', '%"ROLE_ADMIN"%');


        return $qb->getQuery()->getResult();
    }
}