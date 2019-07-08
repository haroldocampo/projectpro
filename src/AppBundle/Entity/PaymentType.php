<?php
/**
 * Created by PhpStorm.
 * User: marks
 * Date: 9/30/2017
 * Time: 6:57 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PaymentTypeRepository")
 * @ORM\Table(name="paymentType")
 * @ORM\HasLifecycleCallbacks
 * @Serializer\ExclusionPolicy("all")
 */
class PaymentType
{

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
     * @ORM\Column(type="datetime")
     */
    protected $dateCreated;
    
    /**
     * @ORM\Column(type="boolean")
     * @Serializer\Expose
     */
    protected $enabled = true;
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\EmployeePaymentType", mappedBy="paymentType")
     * @Serializer\Expose
     */
    protected $employeePaymentTypes;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Company", inversedBy="paymentTypes")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     * @Serializer\Expose
     */
    protected $company;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Purchase", mappedBy="paymentType")
     */
    protected $purchases;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TransactionType", inversedBy="paymentTypes")
     * @ORM\JoinColumn(name="transaction_type_id", referencedColumnName="id")
     * @Serializer\Expose
     */
    protected $transactionType;

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        if ($this->getDateCreated() == null) {
            $this->setDateCreated(new \DateTime('now'));
        }
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
     * @return PaymentType
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
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return PaymentType
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set company
     *
     * @param \AppBundle\Entity\Company $company
     *
     * @return PaymentType
     */
    public function setCompany(\AppBundle\Entity\Company $company = null)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return \AppBundle\Entity\Company
     */
    public function getCompany()
    {
        return $this->company;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->purchases = new \Doctrine\Common\Collections\ArrayCollection();
        $this->employeePaymentTypes = new \Doctrine\Common\Collections\ArrayCollection(); 
    }

    /**
     * Add purchase
     *
     * @param \AppBundle\Entity\Purchase $purchase
     *
     * @return PaymentType
     */
    public function addPurchase(\AppBundle\Entity\Purchase $purchase)
    {
        $this->purchases[] = $purchase;

        return $this;
    }
    
    public function getHasEmployeePaymentTypes()
    {
        return count($this->employeePaymentTypes) > 0;
    }
    
    public function getHasPurchases()
    {
        return count($this->purchases) > 0;
    }
    
    

    /**
     * Remove purchase
     *
     * @param \AppBundle\Entity\Purchase $purchase
     */
    public function removePurchase(\AppBundle\Entity\Purchase $purchase)
    {
        $this->purchases->removeElement($purchase);
    }

    /**
     * Get purchases
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPurchases()
    {
        return $this->purchases;
    }
    
    
    /**
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return Cost
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Add employeePaymentType
     *
     * @param \AppBundle\Entity\EmployeePaymentType $employeePaymentType
     *
     * @return PaymentType
     */
    public function addEmployeePaymentType(\AppBundle\Entity\EmployeePaymentType $employeePaymentType)
    {
        $this->employeePaymentTypes[] = $employeePaymentType;

        return $this;
    }

    /**
     * Remove employeePaymentType
     *
     * @param \AppBundle\Entity\EmployeePaymentType $employeePaymentType
     */
    public function removeEmployeePaymentType(\AppBundle\Entity\EmployeePaymentType $employeePaymentType)
    {
        $this->employeePaymentTypes->removeElement($employeePaymentType);
    }

    /**
     * Get employeePaymentTypes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmployeePaymentTypes()
    {
        return $this->employeePaymentTypes;
    }

    /**
     * Set transactionType
     *
     * @param \AppBundle\Entity\TransactionType $transactionType
     *
     * @return PaymentType
     */
    public function setTransactionType(\AppBundle\Entity\TransactionType $transactionType = null)
    {
        $this->transactionType = $transactionType;

        return $this;
    }

    /**
     * Get transactionType
     *
     * @return \AppBundle\Entity\TransactionType
     */
    public function getTransactionType()
    {
        return $this->transactionType;
    }
}
