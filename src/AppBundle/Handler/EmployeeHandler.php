<?php
/**
 * Created by PhpStorm.
 * User: marks
 * Date: 9/22/2017
 * Time: 5:52 PM
 */

namespace AppBundle\Handler;


use AppBundle\Entity\Company;
use AppBundle\Entity\Employee;
use AppBundle\Entity\User;
use Psr\Container\ContainerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class EmployeeHandler
{

    private $entityManager;
    private $mailer;
    private $templating;
    private $router;

    /**
     * EmployeeHandler constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container) {
        $this->entityManager = $container->get('doctrine.orm.default_entity_manager');
        $this->mailer = $container->get('mailer');
        $this->templating = $container->get('templating');
        $this->router = $container->get('router');
    }

    /**
     * @param User $user
     * @param Company $company
     * @param User $admin
     * @param array $roles
     * @param bool $isDefaultAccountant
     * @return null|object
     * @throws \Twig\Error\Error
     */
    public function createEmployee(User $user, Company $company, User $admin, $roles = [], $isDefaultAccountant = false) {
        $employee = $this->entityManager->getRepository('AppBundle:Employee')->findOneBy(['user' => $user, 'company' => $company]);

        if ($employee) {
            $this->addRoles($employee, $roles);
        } else {
            $employments = $user->getEmployments();

            $sendEmail = false;
            if ($user->getEmail() != $admin->getEmail() && count($employments) == 0) {
                $sendEmail = true;
            }

            $employee = $this->entityManager->getRepository('AppBundle:Employee')
                ->create($user, $company, $roles, $isDefaultAccountant);


            if ($sendEmail) {
                $setPassword = ($user->getPasswordSetToken() != null) ? true : false;

                $message = (new \Swift_Message('Welcome to ProjectPro!'))
                    ->setFrom('credentials@projectprohub.com')
                    ->setTo($user->getEmail())
                    ->setBody($this->templating->render(
                        'email/welcome_email_roles.html.twig',
                        [
                            'user' => $user,
                            'passwordSetUrl' => $this->generatePasswordSetUrl($user->getId(), $user->getPasswordSetToken()),
                            'companyName' => $company->getName(),
                            'admin' => $admin,
                            'roles' => [
                                'isAccountant' => $employee->hasRole(Employee::$ROLE_ACCOUNTANT),
                                'isApprover' => $employee->hasRole(Employee::$ROLE_APPROVER),
                                'isPurchaser' => $employee->hasRole(Employee::$ROLE_PURCHASER),
                                'isAdmin' => $employee->hasRole(Employee::$ROLE_ADMIN)
                            ],
                            'setPassword' => $setPassword
                        ]),
                        'text/html'
                    );

                $this->mailer->send($message);
            }
        }

        return $employee;
    }

    /**
     * @param Employee $employee
     * @param $roles array
     * @return Employee
     */
    public function setRoles(Employee $employee, $roles) {
        $employee->setRoles([]);

        foreach ($roles as $role) {
            if ($role == 'approver') {
                $employee->addRole(Employee::$ROLE_APPROVER);
            } elseif ($role == 'accountant') {
                $employee->addRole(Employee::$ROLE_ACCOUNTANT);
            } elseif ($role == 'admin') {
                $employee->addRole(Employee::$ROLE_ADMIN);
            }
        }

        return $employee;
    }

    public function addRoles(Employee $employee, $roles) {
        foreach ($roles as $role) {
            if ($role == 'approver') {
                $employee->addRole(Employee::$ROLE_APPROVER);
            } elseif ($role == 'accountant') {
                $employee->addRole(Employee::$ROLE_ACCOUNTANT);
            } elseif ($role == 'admin') {
                $employee->addRole(Employee::$ROLE_ADMIN);
            }
        }
        return $employee;
    }

    /**
     * @param int $length
     * @return bool|string
     */
    private function generateRandomString($length = 24)
    {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }

    /**
     * @param $userId
     * @param $passwordSetToken
     * @return string
     */
    private function generatePasswordSetUrl($userId, $passwordSetToken)
    {
        return $this->router->generate('accountSetPassword', [], UrlGeneratorInterface::ABSOLUTE_URL) . '?uid=' . $userId . '&t=' . $passwordSetToken;
    }

}