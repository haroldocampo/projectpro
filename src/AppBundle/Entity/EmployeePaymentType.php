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
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EmployeePaymentTypeRepository")
 * @ORM\Table(name="employee_payment_type")
 * @ORM\HasLifecycleCallbacks
 * @Serializer\ExclusionPolicy("all")
 */
class EmployeePaymentType {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Expose
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Employee", inversedBy="employeePaymentTypes")
     * @ORM\JoinColumn(name="employee_id", referencedColumnName="id")
     * @Serializer\Exclude
     */
    protected $employee;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PaymentType", inversedBy="employeePaymentTypes")
     * @ORM\JoinColumn(name="payment_type_id", referencedColumnName="id")
     * @Serializer\Exclude
     */
    protected $paymentType;

    /**
     * @ORM\Column(type="boolean")
     * @Serializer\Expose
     */
    protected $enabled = true;

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("employeeId")
     */
    public function getEmployeeId() {
        return $this->employee->getId();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set employee
     *
     * @param \AppBundle\Entity\Employee $employee
     *
     * @return EmployeePaymentType
     */
    public function setEmployee(\AppBundle\Entity\Employee $employee = null) {
        $this->employee = $employee;

        return $this;
    }

    /**
     * Get employee
     *
     * @return \AppBundle\Entity\Employee
     */
    public function getEmployee() {
        return $this->employee;
    }

    /**
     * Set paymentType
     *
     * @param \AppBundle\Entity\PaymentType $paymentType
     *
     * @return EmployeePaymentType
     */
    public function setPaymentType(\AppBundle\Entity\PaymentType $paymentType = null) {
        $this->paymentType = $paymentType;

        return $this;
    }

    /**
     * Get paymentType
     *
     * @return \AppBundle\Entity\PaymentType
     */
    public function getPaymentType() {
        return $this->paymentType;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return EmployeePaymentType
     */
    public function setEnabled($enabled) {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled() {
        return $this->enabled;
    }

}
