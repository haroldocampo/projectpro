<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PurchaseClassRepository")
 * @ORM\Table(name="purchaseClass")
 * @ORM\HasLifecycleCallbacks
 * @Serializer\ExclusionPolicy("all")
 */
class PurchaseClass
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Company", inversedBy="purchaseClasses")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     * @Serializer\Expose
     */
    protected $company;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\PurchaseItem", mappedBy="purchaseClass")
     */
    protected $purchaseItems;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->purchaseItems = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return PurchaseClass
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
     * Set company
     *
     * @param \AppBundle\Entity\Company $company
     *
     * @return PurchaseClass
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
     * Add purchaseItem
     *
     * @param \AppBundle\Entity\PurchaseItem $purchaseItem
     *
     * @return PurchaseClass
     */
    public function addPurchaseItem(\AppBundle\Entity\PurchaseItem $purchaseItem)
    {
        $this->purchaseItems[] = $purchaseItem;

        return $this;
    }

    /**
     * Remove purchaseItem
     *
     * @param \AppBundle\Entity\PurchaseItem $purchaseItem
     */
    public function removePurchaseItem(\AppBundle\Entity\PurchaseItem $purchaseItem)
    {
        $this->purchaseItems->removeElement($purchaseItem);
    }

    /**
     * Get purchaseItems
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPurchaseItems()
    {
        return $this->purchaseItems;
    }

    public function getHasPurchases()
    {
        return count($this->purchaseItems) > 0;
    }

}
