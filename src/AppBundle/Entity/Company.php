<?php
/**
 * Created by PhpStorm.
 * User: marks
 * Date: 9/19/2017
 * Time: 7:03 PM
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\Accessor as Accessor;
use Doctrine\Common\Collections\Criteria;
    
/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CompanyRepository")
 * @ORM\Table(name="company")
 * @ORM\HasLifecycleCallbacks
 * @Serializer\ExclusionPolicy("all")
 */
class Company
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $subscriptionId;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $dateTimeCreated;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Employee", mappedBy="company")
     */
    protected $employees;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Project", mappedBy="company")
     */
    protected $projects;


    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ArchivedCustomerJob", mappedBy="company")
     */
    protected $archivedCustomerJobs;
    

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ReminderJob", mappedBy="company")
     */
    protected $reminderJobs;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\PaymentType", mappedBy="company")
     * @Accessor(getter="getActivePaymentTypes")
     * @Serializer\Expose
     */
    protected $paymentTypes;
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\DisabledExpenseType", mappedBy="company")
     */
    protected $disabledExpenseTypes;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ImportedTransaction", mappedBy="company")
     */
    protected $importedTransactions;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Expose
     */
    protected $billingPortalLink;
    /**
     * @ORM\Column(type="boolean")
     * @Serializer\Expose
     */
    protected $qbIntegrated = false;

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
        $this->employees = new ArrayCollection();
        $this->projects = new ArrayCollection();
        $this->reminderJobs = new ArrayCollection();
        $this->paymentTypes = new ArrayCollection();
        $this->disabledExpenseTypes = new ArrayCollection();
        $this->importedTransactions = new ArrayCollection();
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
     * @return Company
     */
    public function setName($name)
    {
        $this->name = trim($name);
    
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
     * Set dateTimeCreated
     *
     * @param \DateTime $dateTimeCreated
     *
     * @return Company
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
     * Add employee
     *
     * @param \AppBundle\Entity\Employee $employee
     *
     * @return Company
     */
    public function addEmployee(\AppBundle\Entity\Employee $employee)
    {
        $this->employees[] = $employee;

        return $this;
    }

    /**
     * Remove employee
     *
     * @param \AppBundle\Entity\Employee $employee
     */
    public function removeEmployee(\AppBundle\Entity\Employee $employee)
    {
        $this->employees->removeElement($employee);
    }

    /**
     * Get employees
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmployees()
    {
        return $this->employees;
    }

    /**
     * Add project
     *
     * @param \AppBundle\Entity\Project $project
     *
     * @return Company
     */
    public function addProject(\AppBundle\Entity\Project $project)
    {
        $this->projects[] = $project;

        return $this;
    }

    /**
     * Remove project
     *
     * @param \AppBundle\Entity\Project $project
     */
    public function removeProject(\AppBundle\Entity\Project $project)
    {
        $this->projects->removeElement($project);
    }

    /**
     * Get projects
     *
     * @return ArrayCollection
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * Add reminderJob
     *
     * @param \AppBundle\Entity\ReminderJob $reminderJob
     *
     * @return Company
     */
    public function addReminderJob(\AppBundle\Entity\ReminderJob $reminderJob)
    {
        $this->reminderJobs[] = $reminderJob;

        return $this;
    }

    /**
     * Remove reminderJob
     *
     * @param \AppBundle\Entity\ReminderJob $reminderJob
     */
    public function removeReminderJob(\AppBundle\Entity\ReminderJob $reminderJob)
    {
        $this->reminderJobs->removeElement($reminderJob);
    }

    /**
     * Get reminderJob
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReminderJob()
    {
        return $this->reminderJob;
    }

    /**
     * Get reminderJobs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReminderJobs()
    {
        return $this->reminderJobs;
    }

    
    /**
     * Add disabledExpenseType
     *
     * @param \AppBundle\Entity\DisabledExpenseType $disabledExpenseType
     *
     * @return Company
     */
    public function addDisabledExpenseType(\AppBundle\Entity\DisabledExpenseType $disabledExpenseType)
    {
        $this->disabledExpenseTypes[] = $disabledExpenseType;

        return $this;
    }

    /**
     * Remove disabledExpenseType
     *
     * @param \AppBundle\Entity\DisabledExpenseType $disabledExpenseType
     */
    public function removeDisabledExpenseType(\AppBundle\Entity\DisabledExpenseType $disabledExpenseType)
    {
        $this->disabledExpenseTypes->removeElement($disabledExpenseType);
    }

    /**
     * Get disabledExpenseTypes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDisabledExpenseTypes()
    {
       return $this->disabledExpenseTypes;
    }
    
    /**
     * Add paymentType
     *
     * @param \AppBundle\Entity\PaymentType $paymentType
     *
     * @return Company
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
        $criteria = Criteria::create();
        $criteria->where(Criteria::expr()->eq('enabled', true));

       return $this->paymentTypes->matching($criteria);
    }
    
    /**
     * Get paymentTypes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActivePaymentTypes()
    {
       $criteria = Criteria::create();
       $criteria->where(Criteria::expr()->eq('enabled', true));

       return $this->paymentTypes->matching($criteria);
    }
    


    /**
     * Add importedTransaction
     *
     * @param \AppBundle\Entity\ImportedTransaction $importedTransaction
     *
     * @return Company
     */
    public function addImportedTransaction(\AppBundle\Entity\ImportedTransaction $importedTransaction)
    {
        $this->importedTransactions[] = $importedTransaction;

        return $this;
    }

    /**
     * Remove importedTransaction
     *
     * @param \AppBundle\Entity\ImportedTransaction $importedTransaction
     */
    public function removeImportedTransaction(\AppBundle\Entity\ImportedTransaction $importedTransaction)
    {
        $this->importedTransactions->removeElement($importedTransaction);
    }

    /**
     * Get importedTransactions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImportedTransactions()
    {
        return $this->importedTransactions;
    }

    /**
     * Set subscriptionId
     *
     * @param string $subscriptionId
     *
     * @return Company
     */
    public function setSubscriptionId($subscriptionId)
    {
        $this->subscriptionId = $subscriptionId;

        return $this;
    }

    /**
     * Get subscriptionId
     *
     * @return string
     */
    public function getSubscriptionId()
    {
        return $this->subscriptionId;
    }
    
    /**
     * Get billing portal link
     *
     * @return string
     */
    public function getBillingPortalLink()
    {
        return $this->billingPortalLink;
    }

    /**
     * Set name
     *
     * @param string $billingPortalLink
     *
     * @return Company
     */
    public function setBillingPortalLink($billingPortalLink)
    {
        $this->billingPortalLink = $billingPortalLink;
    
        return $this;
    }
    /**
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return Cost
     */
    public function setQbIntegrated($qbIntegrated)
    {
        $this->qbIntegrated = $qbIntegrated;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function isQbIntegrated()
    {
        return $this->qbIntegrated;
    }

    /**
     * Get qbIntegrated
     *
     * @return boolean
     */
    public function getQbIntegrated()
    {
        return $this->qbIntegrated;
    }

    /**
     * Add archivedCustomerJob
     *
     * @param \AppBundle\Entity\ArchivedCustomerJob $archivedCustomerJob
     *
     * @return Company
     */
    public function addArchivedCustomerJob(\AppBundle\Entity\ArchivedCustomerJob $archivedCustomerJob)
    {
        $this->archivedCustomerJobs[] = $archivedCustomerJob;

        return $this;
    }

    /**
     * Remove archivedCustomerJob
     *
     * @param \AppBundle\Entity\ArchivedCustomerJob $archivedCustomerJob
     */
    public function removeArchivedCustomerJob(\AppBundle\Entity\ArchivedCustomerJob $archivedCustomerJob)
    {
        $this->archivedCustomerJobs->removeElement($archivedCustomerJob);
    }

    /**
     * Get archivedCustomerJobs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArchivedCustomerJobs()
    {
        return $this->archivedCustomerJobs;
    }
}
