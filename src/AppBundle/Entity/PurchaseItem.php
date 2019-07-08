<?php
/**
 * Created by PhpStorm.
 * User: marksegalle
 * Date: 27/09/2017
 * Time: 9:20 AM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PurchaseItemRepository")
 * @ORM\Table(name="purchase_item")
 * @ORM\HasLifecycleCallbacks
 * @Serializer\ExclusionPolicy("all")
 */
class PurchaseItem
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Expose
     */
    protected $id;

    /**
     * @ORM\Column(type="decimal", precision=13, scale=2)
     * @Serializer\Expose
     */
    protected $amount;

    /**
     * @ORM\Column(type="decimal", precision=13, scale=2)
     * @Serializer\Expose
     */
    protected $tax;

    /**
     * @ORM\Column(type="decimal", precision=13, scale=2)
     * @Serializer\Expose
     */
    protected $taxedAmount;

    /**
     * @ORM\Column(type="datetime")
     * @Serializer\Expose
     */
    protected $dateCreated;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Cost", inversedBy="purchaseItems")
     * @ORM\JoinColumn(name="cost_id", referencedColumnName="id")
     * @Serializer\Expose
     */
    protected $cost;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Purchase", inversedBy="purchaseItems")
     * @ORM\JoinColumn(name="purchase_id", referencedColumnName="id")
     * @Serializer\Expose
     */
    protected $purchase;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Expose
     */
    protected $memo;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\QbException", mappedBy="purchaseItem")
     */
    protected $qbExceptions;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PurchaseClass", inversedBy="purchaseItems")
     * @ORM\JoinColumn(name="purchase_class_id", referencedColumnName="id")
     * @Serializer\Expose
     * @Serializer\MaxDepth(2)
     */
    protected $purchaseClass;

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
     * Set amount
     *
     * @param string $amount
     *
     * @return PurchaseItem
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    
        return $this;
    }

    /**
     * Get amount
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return PurchaseItem
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
     * Set cost
     *
     * @param \AppBundle\Entity\Cost $cost
     *
     * @return PurchaseItem
     */
    public function setCost(\AppBundle\Entity\Cost $cost = null)
    {
        $this->cost = $cost;
    
        return $this;
    }

    /**
     * Get cost
     *
     * @return \AppBundle\Entity\Cost
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set purchase
     *
     * @param \AppBundle\Entity\Purchase $purchase
     *
     * @return PurchaseItem
     */
    public function setPurchase(\AppBundle\Entity\Purchase $purchase = null)
    {
        $this->purchase = $purchase;
    
        return $this;
    }

    /**
     * Get purchase
     *
     * @return \AppBundle\Entity\Purchase
     */
    public function getPurchase()
    {
        return $this->purchase;
    }

    /**
     * Set tax
     *
     * @param string $tax
     *
     * @return PurchaseItem
     */
    public function setTax($tax)
    {
        $this->tax = $tax;

        return $this;
    }

    /**
     * Get tax
     *
     * @return string
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * Set taxedAmount
     *
     * @param string $taxedAmount
     *
     * @return PurchaseItem
     */
    public function setTaxedAmount($taxedAmount)
    {
        $this->taxedAmount = $taxedAmount;

        return $this;
    }

    /**
     * Get taxedAmount
     *
     * @return string
     */
    public function getTaxedAmount()
    {
        return $this->taxedAmount;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->qbExceptions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add qbException
     *
     * @param \AppBundle\Entity\QbException $qbException
     *
     * @return PurchaseItem
     */
    public function addQbException(\AppBundle\Entity\QbException $qbException)
    {
        $this->qbExceptions[] = $qbException;

        return $this;
    }

    /**
     * Remove qbException
     *
     * @param \AppBundle\Entity\QbException $qbException
     */
    public function removeQbException(\AppBundle\Entity\QbException $qbException)
    {
        $this->qbExceptions->removeElement($qbException);
    }

    /**
     * Get qbExceptions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQbExceptions()
    {
        return $this->qbExceptions;
    }

    /**
     * Set purchaseClass
     *
     * @param \AppBundle\Entity\PurchaseClass $purchaseClass
     *
     * @return PurchaseItem
     */
    public function setPurchaseClass(\AppBundle\Entity\PurchaseClass $purchaseClass = null)
    {
        $this->purchaseClass = $purchaseClass;

        return $this;
    }

    /**
     * Get purchaseClass
     *
     * @return \AppBundle\Entity\PurchaseClass
     */
    public function getPurchaseClass()
    {
        return $this->purchaseClass;
    }

    /**
     * Set memo
     *
     * @param string $memo
     *
     * @return PurchaseItem
     */
    public function setMemo($memo)
    {
        $this->memo = $memo;

        return $this;
    }

    /**
     * Get memo
     *
     * @return string
     */
    public function getMemo()
    {
        return $this->memo;
    }
}
