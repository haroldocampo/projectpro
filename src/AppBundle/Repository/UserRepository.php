<?php
namespace AppBundle\Repository;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
class UserRepository extends EntityRepository
{    
    /**
     * @param Project $project
     * @param string $codeNumber
     * @param string $expenseType
     * @param string $description
     * @param float $budgetAmount 
     * @return array
     */ 
    public function create($um, $firstName, $lastName, $email, $password, $accountantEmail = false, $randomString = false){                
        $user = $um->createUser();
        $user->setEmail($email)
            ->setPlainPassword($password)
            ->setEnabled(true)
            ->setFirstName($firstName)
            ->setLastName($lastName);
        if ($accountantEmail)
            $user->setAccountantEmail($accountantEmail);                        
        if($randomString)
            $user->setPasswordSetToken($this->generateRandomString());
        $um->updateUser($user);   
        return $user; //9712 pwd
    }
    public function findCompanies($user, $isAdmin){
        $companies = [];
        if ($isAdmin) {
            $allCompanies = $this->getEntityManager()
                ->getRepository('AppBundle:Company')
                ->findBy([], ['name' => 'ASC']);

            foreach ($allCompanies as $company) {
                array_push($companies, [
                    'id' => $company->getId(),
                    'name' => $company->getName(),
                    'employeeCount' => count($company->getEmployees()),
                    'isAdmin' => false
                ]);
            }
        } else {
            $employeeRecords = $this->getEntityManager()
                ->getRepository('AppBundle:Employee')
                ->findBy(['user' => $user]);

            foreach ($employeeRecords as $employeeRecord) {
                
                if($employeeRecord->getEnabled() == false){
                    continue;
                }
                $company = $employeeRecord->getCompany();                
                array_push($companies, [
                    'id' => $company->getId(),
                    'name' => $company->getName(),
                    'employeeCount' => count($company->getEmployees()),
                    'isAdmin' => false
                ]);
            }

            // sort
            $name = [];
            foreach ($companies as $key => $row) {
                $name[$key] = $row['name'];
            }
            array_multisort($name, SORT_ASC, $companies);

        }
        return $companies;
    }
}