<?php
/**
 * Created by PhpStorm.
 * User: marksegalle
 * Date: 01/10/2017
 * Time: 7:41 PM
 */

namespace AppBundle\Repository;


use AppBundle\Entity\Company;
use Doctrine\ORM\EntityRepository;

class ReminderJobRepository extends EntityRepository
{

    /**
     * @param Company $company
     * @param $type
     * @return mixed
     */
    public function findOneByCompanyAndType(Company $company, $type) {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('reminderJob')
            ->from('AppBundle:ReminderJob', 'reminderJob')
            ->where('reminderJob.company = :company')
            ->setParameter('company', $company)
            ->andWhere('reminderJob.type = :type')
            ->setParameter('type', $type);
//
//        $qb->select('reminderJob')
//            ->from('AppBundle:ReminderJob', 'reminderJob')
//            ->where($qb->expr()->andX(
//                $qb->expr()->eq('reminderJob.company', $company),
//                $qb->expr()->eq('reminderJob.type', '?' . $type)
//            ));

        return $qb->getQuery()->getOneOrNullResult();
    }

}