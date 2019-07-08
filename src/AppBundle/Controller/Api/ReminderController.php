<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Company;
use AppBundle\Entity\Employee;
use AppBundle\Entity\ReminderJob;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ReminderController extends Controller
{
    private $typeApprover = 'approver';
    private $typePurchaser = 'purchaser';

    /**
     * @Route("/api/reminder/all", name="apiReminderSendToAll")
     * @Method("POST")
     */
    public function sendReminderToAllAction(Request $request)
    {
        $params = $this->getRequest();
        $userId = $this->getUser()->getId();
        $companyId = $params['companyId'];
        $to = $params['to']; // purchaser or approver

        $user = $this->getDoctrine()
            ->getRepository('AppBundle:User')
            ->find($userId);

        if (!$user) {
            throw $this->createNotFoundException(
                sprintf(
                    'No user found with id %s',
                    $userId
                )
            );
        }

        $company = $this->getDoctrine()
            ->getRepository('AppBundle:Company')
            ->find($companyId);

        if (!$company) {
            throw $this->createNotFoundException(
                sprintf(
                    'No company found with id %s',
                    $companyId
                )
            );
        }

        switch ($to) {
            case 'approver':
                $to = ReminderJob::$TYPE_APPROVER;
                break;
            case 'purchaser':
                $to = ReminderJob::$TYPE_PURCHASER;
                break;
        }

        $this->sendReminder($company, $user, $to);

        return new JsonResponse(['success' => true]);
    }

    /**
     * @Route("/api/reminder/scheduled", name="apiReminderSendScheduled")
     * @Method("GET")
     */
    public function sendScheduledReminders()
    {
        $reminderJobs = $this->getDoctrine()
            ->getRepository('AppBundle:ReminderJob')
            ->findAll();

        $day = date('l');

        $emailCount = 0;

        foreach ($reminderJobs as $reminderJob) {
            switch ($day) {
                case 'Monday':
                    if ($reminderJob->hasDay(ReminderJob::$DAY_MONDAY)) {
//                        $emailCount += $this->sendReminderToBoth($reminderJob->getCompany(), $reminderJob->getSender());
                        $this->sendReminder($reminderJob->getCompany(), $reminderJob->getSender(), $reminderJob->getType());
                    }
                    break;
                case 'Tuesday':
                    if ($reminderJob->hasDay(ReminderJob::$DAY_TUESDAY)) {
                        $this->sendReminder($reminderJob->getCompany(), $reminderJob->getSender(), $reminderJob->getType());
                    }
                    break;
                case 'Wednesday':
                    if ($reminderJob->hasDay(ReminderJob::$DAY_WEDNESDAY)) {
                        $this->sendReminder($reminderJob->getCompany(), $reminderJob->getSender(), $reminderJob->getType());
                    }
                    break;
                case 'Thursday':
                    if ($reminderJob->hasDay(ReminderJob::$DAY_THURSDAY)) {
                        $this->sendReminder($reminderJob->getCompany(), $reminderJob->getSender(), $reminderJob->getType());
                    }
                    break;
                case 'Friday':
                    if ($reminderJob->hasDay(ReminderJob::$DAY_FRIDAY)) {
                        $this->sendReminder($reminderJob->getCompany(), $reminderJob->getSender(), $reminderJob->getType());
                    }
                    break;
            }
        }

        return new JsonResponse(
            [
                'success' => true,
                'emailCount' => $emailCount,
            ]
        );
    }
    
    /**
     * @Route("/api/company/{id}/reminder/scheduled", name="apiCompanyReminderSendScheduled")
     * @Method("POST")
     */
    public function getCompanyScheduledReminders($id, Request $request)
    {
        $params = $this->getRequest();
        $type = $params['type'];
        $company = $this->getDoctrine()
                ->getRepository('AppBundle:Company')
                ->find($id);
        
        $reminderJobs = $this->getDoctrine()
            ->getRepository('AppBundle:ReminderJob')
            ->findBy(['company' => $company, 'type' => $type]);

        foreach ($reminderJobs as $reminderJob) {
            $days = $reminderJob->getDays();
        }

        return new JsonResponse(
            [
                'success' => true,
                'days' => $days,
            ]
        );
    }

    /**
     * @Route("/api/reminder/scheduled/set", name="apiCompanyReminderScheduleSet")
     * @Method("POST")
     */
    public function setCompanyScheduledDays(Request $request)
    {
        $params = $this->getRequest();
        $companyId = $params['companyId'];
        $company = $this->getDoctrine()
            ->getRepository('AppBundle:Company')
            ->find($companyId);
        if (!$company) {
            throw $this->createNotFoundException(
                sprintf(
                    'No company found with id %s',
                    $companyId
                )
            );
        }

        $type = $params['type']; // approver or purchaser
        if (!$type) {
            throw $this->createNotFoundException('Missing reminder type');
        }

        $days = $params['days'];
        if (!$days) {
            throw $this->createNotFoundException('Missing reminder days');
        }

        $em = $this->getDoctrine()->getManager();

        switch ($type) {
            case $this->typeApprover:
                $type = ReminderJob::$TYPE_APPROVER;
                break;
            case $this->typePurchaser:
                $type = ReminderJob::$TYPE_PURCHASER;
                break;
        }

        // get reminder job
        $reminderJob = $this->getDoctrine()
            ->getRepository('AppBundle:ReminderJob')
            ->findOneByCompanyAndType($company, $type);

        if (!$reminderJob) {
            $reminderJob = new ReminderJob();
            $reminderJob->setCompany($company)
                ->setSender($this->getUser())
                ->setType($type);
            $em->persist($reminderJob);
            $em->flush();
        }

        $reminderJob->clearDays(); // empty array
        foreach ($days as $day) {
            switch ($day) {
                case 'm':
                    $reminderJob->addDay(ReminderJob::$DAY_MONDAY);
                    break;
                case 't';
                    $reminderJob->addDay(ReminderJob::$DAY_TUESDAY);
                    break;
                case 'w':
                    $reminderJob->addDay(ReminderJob::$DAY_WEDNESDAY);
                    break;
                case 'th':
                    $reminderJob->addDay(ReminderJob::$DAY_THURSDAY);
                    break;
                case 'f':
                    $reminderJob->addDay(ReminderJob::$DAY_FRIDAY);
                    break;
            }
        }
        $em->flush();


        return new JsonResponse(true);
    }

    /**
     * Send reminder to both purchaser and approver
     *
     * @param Company $company
     * @param User $user
     * @return int
     * @deprecated this caused the duplicate reminder bug
     */
    private function sendReminderToBoth(Company $company, User $user)
    {
        $emailCount = 0;

        $emailCount += $this->sendReminder($company, $user, $this->typeApprover);
        $emailCount += $this->sendReminder($company, $user, $this->typePurchaser);

        return $emailCount;
    }

    /**
     * Send reminder
     *
     * @param Company $company
     * @param User $user
     * @param $to
     * @return int
     */
    private function sendReminder(Company $company, User $user, $to)
    {
        $emailCount = 0;

        $subject = $user->getFirstName().' '.$user->getLastName().' sent you a reminder';

        if ($to == ReminderJob::$TYPE_PURCHASER) {
            $employees = $company->getEmployees();

            foreach ($employees as $employee) {
                
                if($employee->getEnabled() == false){
                    continue;
                }
                
                if ($employee->hasRole(Employee::$ROLE_PURCHASER)) {
                    $message = (new \Swift_Message($subject))
                        ->setFrom('reminders@projectprohub.com')
                        ->setTo($employee->getUser()->getEmail())
                        ->setBody(
                            $this->renderView(
                                'email/reminder_purchaser.html.twig'
                            ),
                            'text/html'
                        );

                    $this->get('mailer')->send($message);
                    $emailCount += 1;
                }
            }
        } elseif ($to == ReminderJob::$TYPE_APPROVER) {

            $employees = $company->getEmployees();

            foreach ($employees as $employee) {
                
                if($employee->getEnabled() == false){
                    continue;
                }
                
                if ($employee->hasRole(Employee::$ROLE_APPROVER)) {
                    $purchases = $this->getDoctrine()->getManager()
                        ->createQueryBuilder()
                        ->select('p')
                        ->from('AppBundle:Purchase', 'p')
                        ->innerJoin('p.project','proj')
                        ->innerJoin('proj.approver','approver')
                        ->where("approver.id = :approver_id and p.status = 'STATUS_NOT_APPROVED'")
                        //->where("p.status = :status")
                        ->setParameter('approver_id', $employee->getId())
                        //->setParameter('status', \AppBundle\Entity\Purchase::$STATUS_NOT_APPROVED)
                        ->getQuery()
                        ->getResult();

                    $unapprovedCount = count($purchases);

                    if ($unapprovedCount > 0) {
                        $message = (new \Swift_Message($subject))
                            ->setFrom('reminders@projectprohub.com')
                            ->setTo($employee->getUser()->getEmail())
                            ->setBody(
                                $this->renderView(
                                    'email/reminder_approver.html.twig', [
                                        'company' => $employee->getCompany(),
                                        'purchasesCount' => $unapprovedCount
                                    ]
                                ),
                                'text/html'
                            );

                        $this->get('mailer')->send($message);
                        $emailCount += 1;
                    }
                }
            }

        } else {
            throw $this->createNotFoundException(
                sprintf(
                    'Reminder type %s not found',
                    $to
                )
            );
        }

        return $emailCount;
    }

    private function getRequest()
    {
        $params = array();
        $content = $this->container->get('request_stack')->getCurrentRequest()->getContent();

        if (!empty($content)) {
            $params = json_decode($content, true); // 2nd param to get as array
        }

        return $params;
    }
}
