<?php
/**
 * Created by PhpStorm.
 * User: marks
 * Date: 9/25/2017
 * Time: 10:29 PM
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CostRepository")
 * @ORM\Table(name="cost")
 * @ORM\HasLifecycleCallbacks
 * @Serializer\ExclusionPolicy("all")
 */
class Cost
{
    public static $CLASS_ITEM = 'ITEM';
    public static $CLASS_EXPENSE = 'EXPENSE';

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
    protected $codeNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Expose
     */
    protected $expenseType = 'ITEM';

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Expose
     */
    protected $description;

    /**
     * @ORM\Column(type="decimal", precision=19, scale=4)
     * @Serializer\Expose
     */
    protected $budgetAmount = 0;

    /**
     * @ORM\Column(type="string", length=4)
     * @Serializer\Expose
     */
    protected $currency = 'USD';

    /**
     * @ORM\Column(type="boolean")
     * @Serializer\Expose
     */
    protected $enabled = true;

    /**
     * @ORM\Column(type="boolean")
     * @Serializer\Expose
     */
    protected $notify = true;

    // TODO: execute sql to set all to true upon database update
    /**
     * @ORM\Column(type="boolean")
     * @Serializer\Expose
     */
    protected $hidden = false;

    /**
     * @ORM\Column(type="datetime")
     * @Serializer\Expose
     */
    protected $dateTimeCreated;
    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\PurchaseItem", mappedBy="cost")
     * @Serializer\Expose
     * @Serializer\MaxDepth(1)
     */
    protected $purchaseItems;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Project", inversedBy="costs")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     * @Serializer\Expose
     * @Serializer\MaxDepth(2)
     */
    protected $project;

    /**
     * @ORM\Column(type="string", nullable=true,options={"default" : "ITEM"})     
     * @Serializer\Expose
     * @Serializer\MaxDepth(2)
     */
    protected $costClass;

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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set costCodeNumber
     *
     * @param string $codeNumber
     *
     * @return Cost
     */
    public function setCodeNumber($codeNumber)
    {
        $this->codeNumber = $codeNumber;
    
        return $this;
    }

    /**
     * Get costCodeNumber
     *
     * @return string
     */
    public function getCodeNumber()
    {
        return $this->codeNumber;
    }

    /**
     * Set expenseType
     *
     * @param string $expenseType
     *
     * @return Cost
     */
    public function setExpenseType($expenseType)
    {
        $this->expenseType = $expenseType;
    
        return $this;
    }

    /**
     * Get expenseType
     *
     * @return string
     */
    public function getExpenseType()
    {
        return $this->expenseType;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Cost
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set budgetAmount
     *
     * @param string $budgetAmount
     *
     * @return Cost
     */
    public function setBudgetAmount($budgetAmount)
    {
        $this->budgetAmount = $budgetAmount;
    
        return $this;
    }

    /**
     * Get budgetAmount
     *
     * @return string
     */
    public function getBudgetAmount()
    {
        return $this->budgetAmount;
    }

    /**
     * Set currency
     *
     * @param string $currency
     *
     * @return Cost
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    
        return $this;
    }

    /**
     * Get currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set project
     *
     * @param \AppBundle\Entity\Project $project
     *
     * @return Cost
     */
    public function setProject(\AppBundle\Entity\Project $project = null)
    {
        $this->project = $project;
    
        return $this;
    }

    /**
     * Get project
     *
     * @return \AppBundle\Entity\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set dateTimeCreated
     *
     * @param \DateTime $dateTimeCreated
     *
     * @return Cost
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

    public function isEnabled() {
        return $this->enabled;
    }

    /**
     * Set hidden
     *
     * @param boolean $hidden
     *
     * @return Cost
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;

        return $this;
    }

    /**
     * Get hidden
     *
     * @return boolean
     */
    public function getHidden()
    {
        return $this->hidden;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->purchaseItems = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add purchaseItem.
     *
     * @param \AppBundle\Entity\PurchaseItem $purchaseItem
     *
     * @return Cost
     */
    public function addPurchaseItem(\AppBundle\Entity\PurchaseItem $purchaseItem)
    {
        $this->purchaseItems[] = $purchaseItem;

        return $this;
    }

    /**
     * Remove purchaseItem.
     *
     * @param \AppBundle\Entity\PurchaseItem $purchaseItem
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removePurchaseItem(\AppBundle\Entity\PurchaseItem $purchaseItem)
    {
        return $this->purchaseItems->removeElement($purchaseItem);
    }

    /**
     * Get purchaseItems.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPurchaseItems()
    {
        return $this->purchaseItems;
    }

    /**
     * Set notify
     *
     * @param boolean $notify
     *
     * @return Cost
     */
    public function setNotify($notify)
    {
        $this->notify = $notify;

        return $this;
    }

    /**
     * Get notify
     *
     * @return boolean
     */
    public function getNotify()
    {
        return $this->notify;
    }

    /**
     * Set costClass
     *
     * @param string $costClass
     *
     * @return Cost
     */
    public function setCostClass($costClass)
    {
        $this->costClass = $costClass;

        return $this;
    }

    /**
     * Get costClass
     *
     * @return string
     */
    public function getCostClass()
    {
        return $this->costClass;
    }
}
