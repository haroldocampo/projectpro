<?php
/**
 * Created by PhpStorm.
 * User: marksegalle
 * Date: 07/10/2017
 * Time: 10:33 AM
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ImportedTransactionRepository")
 * @ORM\Table(name="imported_transaction")
 * @ORM\HasLifecycleCallbacks
 * @Serializer\ExclusionPolicy("all")
 */
class ImportedTransaction
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Expose
     */
    protected $id;

    /**
     * @ORM\Column(type="date")
     * @Serializer\Expose
     */
    protected $date;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Expose
     */
    protected $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Expose
     */
    protected $accountNumber;

    /**
     * @ORM\Column(type="decimal", precision=13, scale=2)
     * @Serializer\Expose
     */
    protected $amount;
    
    /**
     * @ORM\Column(type="boolean")
     * @Serializer\Expose
     */
    protected $isDuplicate = false;

    /**
     * @ORM\Column(type="datetime")
     * @Serializer\Expose
     */
    protected $dateCreated;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Company", inversedBy="importedTransactions")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     */
    protected $company;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Purchase", inversedBy="matchedImportedTransaction")
     * @ORM\JoinColumn(name="purchase_item_id", referencedColumnName="id", nullable=true)
     */
    protected $matchedPurchase;

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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return ImportedTransaction
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return ImportedTransaction
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
     * Set accountNumber
     *
     * @param string $accountNumber
     *
     * @return ImportedTransaction
     */
    public function setAccountNumber($accountNumber)
    {
        $this->accountNumber = $accountNumber;

        return $this;
    }

    /**
     * Get accountNumber
     *
     * @return string
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    /**
     * Set amount
     *
     * @param string $amount
     *
     * @return ImportedTransaction
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
     * @return ImportedTransaction
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
     * @return ImportedTransaction
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
     * Set matchedPurchase
     *
     * @param \AppBundle\Entity\Purchase $matchedPurchase
     *
     * @return ImportedTransaction
     */
    public function setMatchedPurchase(\AppBundle\Entity\Purchase $matchedPurchase = null)
    {
        $this->matchedPurchase = $matchedPurchase;

        return $this;
    }

    /**
     * Get matchedPurchase
     *
     * @return \AppBundle\Entity\Purchase
     */
    public function getMatchedPurchase()
    {
        return $this->matchedPurchase;
    }
    
    /**
     * Get id
     *
     * @return boolean
     */
    public function getIsDuplicate()
    {
        return $this->isDuplicate;
    }

    /**
     * Set date
     *
     * @param boolean $isDuplicate
     *
     * @return ImportedTransaction
     */
    public function setIsDuplicate($isDuplicate)
    {
        $this->isDuplicate = $isDuplicate;

        return $this;
    }
}
