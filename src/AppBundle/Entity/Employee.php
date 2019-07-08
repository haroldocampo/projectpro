<?php
/**
 * Created by PhpStorm.
 * User: marksegalle
 * Date: 19/09/2017
 * Time: 9:11 PM
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EmployeeRepository")
 * @ORM\Table(name="employee")
 * @ORM\HasLifecycleCallbacks
 * @Serializer\ExclusionPolicy("all")
 */
class Employee
{

    static public $ROLE_ACCOUNTANT = "ROLE_ACCOUNTANT";
    static public $ROLE_APPROVER = "ROLE_APPROVER";
    static public $ROLE_PURCHASER = "ROLE_PURCHASER";
    static public $ROLE_ADMIN = "ROLE_ADMIN";

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Expose
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Company", inversedBy="employees")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     * @Serializer\Expose
     */
    protected $company;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="employments")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @Serializer\Expose
     */
    protected $user;
    
    /**
     * @ORM\Column(type="boolean")
     * @Serializer\Expose
     */
    protected $enabled = true;

    /**
     * @ORM\Column(type="array")
     * @Serializer\Expose
     */
    protected $roles;

    /**
     * @ORM\Column(type="datetime")
     * @Serializer\Expose
     */
    protected $dateTimeCreated;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isDoneWizard = false;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isImportedToQb = false;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isDefaultAccountant = false;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $chargifyCustomerId;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Project", mappedBy="approver")
     */
    protected $approvedProjects;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Purchase", mappedBy="purchaser")
     */
    protected $purchases;
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Purchase", mappedBy="approver")
     */
    protected $approverPurchases;
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Purchase", mappedBy="decliner")
     */
    protected $declinerPurchases;
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\EmployeePaymentType", mappedBy="employee")
     * @Serializer\Expose
     */
    protected $employeePaymentTypes;

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        if ($this->getDateTimeCreated() == null) {
            $this->setDateTimeCreated(new \DateTime('now'));
        }
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->roles = array();

        $this->approvedProjects = new ArrayCollection();
        $this->purchases = new ArrayCollection();
        $this->employeePaymentTypes = new ArrayCollection();
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
     * @param $role
     * @return $this
     */
    public function addRole($role)
    {
        $role = strtoupper($role);
        if ($role === static::$ROLE_PURCHASER) {
            return $this;
        }

        if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    /**
     * @param $role
     * @return $this
     */
    public function removeRole($role) {
        if (false !== $key = array_search(strtoupper($role), $this->roles, true)) {
            unset($this->roles[$key]);
            $this->roles = array_values($this->roles);
        }

        return $this;
    }

    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles()
    {
        $roles = $this->roles;

        // we need to make sure to have at least one role
        $roles[] = static::$ROLE_PURCHASER;

        return array_unique($roles);
    }

    /**
     * @param $role
     * @return bool
     */
    public function hasRole($role)
    {
        return in_array(strtoupper($role), $this->getRoles(), true);
    }

    /**
     * Set dateTimeCreated
     *
     * @param \DateTime $dateTimeCreated
     *
     * @return Employee
     */
    public function setDateTimeCreated($dateTimeCreated)
    {
        $this->dateTimeCreated = $dateTimeCreated;

        return $this;
    }

    /**
     * Get dateTimeCreated
     *
     * @return \DateTime
     */
    public function getDateTimeCreated()
    {
        return $this->dateTimeCreated;
    }

    /**
     * Set company
     *
     * @param \AppBundle\Entity\Company $company
     *
     * @return Employee
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
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Employee
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set roles
     *
     * @param array $roles
     *
     * @return Employee
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Add approvedProject
     *
     * @param \AppBundle\Entity\Project $approvedProject
     *
     * @return Employee
     */
    public function addApprovedProject(\AppBundle\Entity\Project $approvedProject)
    {
        $this->approvedProjects[] = $approvedProject;

        return $this;
    }

    /**
     * Remove approvedProject
     *
     * @param \AppBundle\Entity\Project $approvedProject
     */
    public function removeApprovedProject(\AppBundle\Entity\Project $approvedProject)
    {
        $this->approvedProjects->removeElement($approvedProject);
    }

    /**
     * Get approvedProjects
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getApprovedProjects()
    {
        return $this->approvedProjects;
    }

    /**
     * Add purchase
     *
     * @param \AppBundle\Entity\Purchase $purchase
     *
     * @return Employee
     */
    public function addPurchase(\AppBundle\Entity\Purchase $purchase)
    {
        $this->purchases[] = $purchase;
    
        return $this;
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
     * Add employeePaymentType
     *
     * @param \AppBundle\Entity\EmployeePaymentType $employeePaymentType
     *
     * @return Employee
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
     * Set enabled.
     *
     * @param bool $enabled
     *
     * @return Employee
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled.
     *
     * @return bool
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set isDoneWizard.
     *
     * @param bool $isDoneWizard
     *
     * @return Employee
     */
    public function setIsDoneWizard($isDoneWizard)
    {
        $this->isDoneWizard = $isDoneWizard;

        return $this;
    }

    /**
     * Get isDoneWizard.
     *
     * @return bool
     */
    public function getIsDoneWizard()
    {
        return $this->isDoneWizard;
    }

    /**
     * Set isDefaultAccountant
     *
     * @param boolean $isDefaultAccountant
     *
     * @return Employee
     */
    public function setIsDefaultAccountant($isDefaultAccountant)
    {
        $this->isDefaultAccountant = $isDefaultAccountant;

        return $this;
    }

    /**
     * Get isDefaultAccountant
     *
     * @return boolean
     */
    public function getIsDefaultAccountant()
    {
        return $this->isDefaultAccountant;
    }

    /**
     * Set chargifyCustomerId
     *
     * @param string $chargifyCustomerId
     *
     * @return Employee
     */
    public function setChargifyCustomerId($chargifyCustomerId)
    {
        $this->chargifyCustomerId = $chargifyCustomerId;

        return $this;
    }

    /**
     * Get chargifyCustomerId
     *
     * @return string
     */
    public function getChargifyCustomerId()
    {
        return $this->chargifyCustomerId;
    }

    /**
     * Add approverPurchase
     *
     * @param \AppBundle\Entity\Purchase $approverPurchase
     *
     * @return Employee
     */
    public function addApproverPurchase(\AppBundle\Entity\Purchase $approverPurchase)
    {
        $this->approverPurchases[] = $approverPurchase;

        return $this;
    }

    /**
     * Remove approverPurchase
     *
     * @param \AppBundle\Entity\Purchase $approverPurchase
     */
    public function removeApproverPurchase(\AppBundle\Entity\Purchase $approverPurchase)
    {
        $this->approverPurchases->removeElement($approverPurchase);
    }

    /**
     * Get approverPurchases
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getApproverPurchases()
    {
        return $this->approverPurchases;
    }

    /**
     * Add declinerPurchase
     *
     * @param \AppBundle\Entity\Purchase $declinerPurchase
     *
     * @return Employee
     */
    public function addDeclinerPurchase(\AppBundle\Entity\Purchase $declinerPurchase)
    {
        $this->declinerPurchases[] = $declinerPurchase;

        return $this;
    }

    /**
     * Remove declinerPurchase
     *
     * @param \AppBundle\Entity\Purchase $declinerPurchase
     */
    public function removeDeclinerPurchase(\AppBundle\Entity\Purchase $declinerPurchase)
    {
        $this->declinerPurchases->removeElement($declinerPurchase);
    }

    /**
     * Get declinerPurchases
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDeclinerPurchases()
    {
        return $this->declinerPurchases;
    }

    /**
     * Set isImportedToQb
     *
     * @param boolean $isImportedToQb
     *
     * @return Employee
     */
    public function setIsImportedToQb($isImportedToQb)
    {
        $this->isImportedToQb = $isImportedToQb;

        return $this;
    }

    /**
     * Get isImportedToQb
     *
     * @return boolean
     */
    public function getIsImportedToQb()
    {
        return $this->isImportedToQb;
    }
}
