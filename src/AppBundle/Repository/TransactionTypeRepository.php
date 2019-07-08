<?php
namespace AppBundle\Repository;

use AppBundle\Entity\PaymentType;
use AppBundle\Entity\TransactionType;
use Doctrine\ORM\EntityRepository;

class TransactionTypeRepository extends EntityRepository
{

    public function create($company, $name, $action)
    {
    }

    public function delete($id)
    {
    }

}