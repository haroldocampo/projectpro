<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TransactionTypeRepository")
 * @ORM\Table(name="transactionType")
 * @ORM\HasLifecycleCallbacks
 * @Serializer\ExclusionPolicy("all")
 */
class TransactionType {
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Expose
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Expose
     */
    protected $name;
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Company", inversedBy="transactionTypes")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     * @Serializer\Expose
     */
    //protected $company;
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\PaymentType", mappedBy="transactionType")
     */
    protected $paymentTypes;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->paymentTypes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return TransactionType
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add paymentType
     *
     * @param \AppBundle\Entity\PaymentType $paymentType
     *
     * @return TransactionType
     */
    public function addPaymentType(\AppBundle\Entity\PaymentType $paymentType)
    {
        $this->paymentTypes[] = $paymentType;

        return $this;
    }

    /**
     * Remove paymentType
     *
     * @param \AppBundle\Entity\PaymentType $paymentType
     */
    public function removePaymentType(\AppBundle\Entity\PaymentType $paymentType)
    {
        $this->paymentTypes->removeElement($paymentType);
    }

    /**
     * Get paymentTypes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPaymentTypes()
    {
        return $this->paymentTypes;
    }
}
