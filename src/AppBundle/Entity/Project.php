<?php
/**
 * Created by PhpStorm.
 * User: marks
 * Date: 9/14/2017
 * Time: 7:27 PM
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProjectRepository")
 * @ORM\Table(name="project")
 * @ORM\HasLifecycleCallbacks
 * @Serializer\ExclusionPolicy("all")
 */
class Project
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
     * @Serializer\Expose
     */
    protected $customer;
    
    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Expose
     */
    protected $number;

    /**
     * @ORM\Column(type="boolean")
     * @Serializer\Expose
     */
    protected $enabled = true;

    /**
     * @ORM\Column(type="datetime")
     * @Serializer\Expose
     */
    protected $dateTimeCreated;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Company", inversedBy="projects")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     * @Serializer\Expose
     */
    protected $company;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Employee", inversedBy="approvedProjects")
     * @ORM\JoinColumn(name="approver_id", referencedColumnName="id")
     * @Serializer\Expose
     * @Serializer\MaxDepth(2)
     */
    protected $approver;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Cost", mappedBy="project")
     * @Serializer\Expose
     */
    protected $costs;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Purchase", mappedBy="project")
     */
    protected $purchases;

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
        $this->costs = new ArrayCollection();
        $this->purchases = new ArrayCollection();
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
     * @return Project
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
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Project
     */
    public function setCustomer($customer)
    {
        $this->customer = trim($customer);
        
        if($customer == ''){
            $this->customer = null;
        }

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
     * Set name
     *
     * @param string $number
     *
     * @return Project
     */
    public function setNumber($number)
    {
        $this->number = $number;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set dateTimeCreated
     *
     * @param \DateTime $dateTimeCreated
     *
     * @return Project
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
     * @return Project
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
     * Set approver
     *
     * @param \AppBundle\Entity\Employee $approver
     *
     * @return Project
     */
    public function setApprover(\AppBundle\Entity\Employee $approver = null)
    {
        $this->approver = $approver;

        return $this;
    }

    /**
     * Get approver
     *
     * @return \AppBundle\Entity\Employee
     */
    public function getApprover()
    {
        return $this->approver;
    }


    /**
     * Add cost
     *
     * @param \AppBundle\Entity\Cost $cost
     *
     * @return Project
     */
    public function addCost(\AppBundle\Entity\Cost $cost)
    {
        $this->costs[] = $cost;

        return $this;
    }

    /**
     * Remove cost
     *
     * @param \AppBundle\Entity\Cost $cost
     */
    public function removeCost(\AppBundle\Entity\Cost $cost)
    {
        $this->costs->removeElement($cost);
    }

    /**
     * Get costs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCosts()
    {
//        $results = array();
//        foreach($costs as $cost){
//            if($cost->getEnabled()){
//                $results[] = $cost;
//            }
//        }
//        return $results;
        return $this->costs;
    }    

    /**
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return Project
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
    public function isEnabled()
    {
        return $this->enabled;
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
     * Add purchase
     *
     * @param \AppBundle\Entity\Purchase $purchase
     *
     * @return Project
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
     * Get filtered purchases
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPurchasesBetweenDate($dateStart, $dateEnd)
    {
        $purchases = [];
        $dateStart = date('Y-m-d',strtotime($dateStart));
        $dateEnd = date('Y-m-d',strtotime($dateEnd));
        
        foreach($this->purchases as $purchase){  
            $purchaseDate = date_format($purchase->getDateOfPurchase(), 'Y-m-d');                               
            if($purchaseDate >= $dateStart && $purchaseDate <= $dateEnd){                
                $purchases[] = $purchase;
            }
        }
        return $purchases;
    }
}
