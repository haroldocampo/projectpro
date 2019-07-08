<?php
/**
 * Created by PhpStorm.
 * User: marksegalle
 * Date: 27/09/2017
 * Time: 9:17 AM
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Fresh\VichUploaderSerializationBundle\Annotation as Fresh;


/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PurchaseRepository")
 * @ORM\Table(name="purchase")
 * @ORM\HasLifecycleCallbacks
 * @Serializer\ExclusionPolicy("all")
 * @Vich\Uploadable
 * @Fresh\VichSerializableClass
 */
class Purchase
{
    static public $STATUS_NOT_APPROVED = "STATUS_NOT_APPROVED";
    static public $STATUS_APPROVED = "STATUS_APPROVED";
    static public $STATUS_DECLINED = "STATUS_DECLINED";

    public static $IMPORT_DISABLED = 'DISABLED';
    public static $IMPORT_ENABLED = 'ENABLED';
    public static $IMPORT_PENDING = 'PENDING';
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Expose
     */
    protected $id;

    /**
     * @ORM\Column(type="date")
     * @Serializer\Type("DateTime<'m/d/Y'>")
     * @Serializer\Expose
     */
    protected $dateOfPurchase;

    /**
     * @ORM\Column(type="datetime")
     * @Serializer\Expose
     */
    protected $dateCreated;
    
    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Expose
     */
    protected $status;
    
    /**
     * @ORM\Column(type="string", length=512, nullable=true)
     * @Serializer\Expose
     */
    protected $comments;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Serializer\Expose
     */
    protected $dateApproved;
    
    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Serializer\Expose
     */
    protected $dateDeclined;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Serializer\Expose
     */
    protected $receiptImageUrl;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Serializer\Expose
     */
    protected $dateExported;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Serializer\Expose
     */
    protected $dateImported;

    /**
     * @ORM\Column(type="decimal", precision=13, scale=2)
     * @Serializer\Expose
     */
    protected $salesTax;

    /**
     * @ORM\Column(type="decimal", precision=13, scale=2)
     * @Serializer\Expose
     */
    protected $totalAmount;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\PurchaseItem", mappedBy="purchase")
     * @Serializer\Expose
     * @Serializer\MaxDepth(3)
     */
    protected $purchaseItems;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Project", inversedBy="purchases")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     * @Serializer\Expose
     * @Serializer\MaxDepth(3)
     */
    protected $project;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Employee", inversedBy="purchases")
     * @ORM\JoinColumn(name="purchaser_id", referencedColumnName="id")
     * @Serializer\Expose
     * @Serializer\MaxDepth(2)
     */
    protected $purchaser;
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Employee", inversedBy="approverPurchases")
     * @ORM\JoinColumn(name="approver_id", referencedColumnName="id")
     * @Serializer\Expose
     * @Serializer\MaxDepth(2)
     */
    protected $approver;
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Employee", inversedBy="declinerPurchases")
     * @ORM\JoinColumn(name="decliner_id", referencedColumnName="id")
     * @Serializer\Expose
     * @Serializer\MaxDepth(2)
     */
    protected $decliner;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PaymentType", inversedBy="purchases")
     * @ORM\JoinColumn(name="payment_type_id", referencedColumnName="id")
     * @Serializer\Expose
     */
    protected $paymentType;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\ImportedTransaction", mappedBy="matchedPurchase")
     * @ORM\JoinColumn(name="imported_transaction_id", referencedColumnName="id", nullable=true)
     * @Serializer\Expose
     * @Serializer\MaxDepth(2)
     */
    protected $matchedImportedTransaction;
    
    /**
     * @ORM\Column(type="boolean")
     * @Serializer\Expose
     */
    protected $isOverrideSalesTax = false;

    /**
     * @ORM\Column(type="boolean")
     * @Serializer\Expose
     */
    protected $isImportedToQuickbooks = false;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vendor", inversedBy="purchases")
     * @ORM\JoinColumn(name="vendor_id", referencedColumnName="id")
     * @Serializer\Expose
     * @Serializer\MaxDepth(2)
     */
    protected $vendor;

    /**     
     * @ORM\Column(type="string",length=8, options={"default" : "DISABLED"})
     * @Serializer\Expose
     * @Serializer\MaxDepth(2)
     */
    protected $qbImport = "DISABLED";

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        if ($this->getDateCreated() == null) {
            $this->setDateCreated(new \DateTime('now'));
        }

        if ($this->getDateOfPurchase() == null) {
            $this->setDateOfPurchase(new \DateTime('now'));
        }
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->purchaseItems = new ArrayCollection();
    }

    // VichUploaderBundle - Start

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Serializer\Expose
     * @Serializer\SerializedName("image")
     *
     * @Fresh\VichSerializableField("imageFile", includeHost=false)
     *
     * @var string
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="purchase_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $updatedAt;

    // ...

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }

    // VichUploaderBundle - End

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
     * Set dateOfPurchase
     *
     * @param \DateTime $dateOfPurchase
     *
     * @return Purchase
     */
    public function setDateOfPurchase($dateOfPurchase)
    {
        $this->dateOfPurchase = $dateOfPurchase;
    
        return $this;
    }

    /**
     * Get dateOfPurchase
     *
     * @return \DateTime
     */
    public function getDateOfPurchase()
    {
        return $this->dateOfPurchase;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Purchase
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
     * Set status
     *
     * @param string $status
     *
     * @return Purchase
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * Set comments
     *
     * @param string $comments
     *
     * @return Purchase
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    
        return $this;
    }

    /**
     * Get comments
     *
     * @return string
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Add purchaseItem
     *
     * @param \AppBundle\Entity\PurchaseItem $purchaseItem
     *
     * @return Purchase
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

    /**
     * Set project
     *
     * @param \AppBundle\Entity\Project $project
     *
     * @return Purchase
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
     * Set purchaser
     *
     * @param \AppBundle\Entity\Employee $purchaser
     *
     * @return Purchase
     */
    public function setPurchaser(\AppBundle\Entity\Employee $purchaser = null)
    {
        $this->purchaser = $purchaser;
    
        return $this;
    }

    /**
     * Get purchaser
     *
     * @return \AppBundle\Entity\Employee
     */
    public function getPurchaser()
    {
        return $this->purchaser;
    }
    
    

    /**
     * Set receiptImageUrl
     *
     * @param string $receiptImageUrl
     *
     * @return Purchase
     */
    public function setReceiptImageUrl($receiptImageUrl)
    {
        $this->receiptImageUrl = $receiptImageUrl;

        return $this;
    }

    /**
     * Get receiptImageUrl
     *
     * @return string
     */
    public function getReceiptImageUrl()
    {
        return $this->receiptImageUrl;
    }

    /**
     * Set paymentType
     *
     * @param \AppBundle\Entity\PaymentType $paymentType
     *
     * @return Purchase
     */
    public function setPaymentType(\AppBundle\Entity\PaymentType $paymentType = null)
    {
        $this->paymentType = $paymentType;

        return $this;
    }

    /**
     * Get paymentType
     *
     * @return \AppBundle\Entity\PaymentType
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }

    /**
     * Set dateApproved
     *
     * @param \DateTime $dateApproved
     *
     * @return Purchase
     */
    public function setDateApproved($dateApproved)
    {
        $this->dateApproved = $dateApproved;

        return $this;
    }

    /**
     * Get dateApproved
     *
     * @return \DateTime
     */
    public function getDateApproved()
    {
        return $this->dateApproved;
    }
    
    /**
     * Set dateDeclined
     *
     * @param \DateTime $dateDeclined
     *
     * @return Purchase
     */
    public function setDateDeclined($dateDeclined)
    {
        $this->dateDeclined = $dateDeclined;

        return $this;
    }

    /**
     * Get dateDeclined
     *
     * @return \DateTime
     */
    public function getDateDeclined()
    {
        return $this->dateDeclined;
    }

    /**
     * Set dateExported
     *
     * @param \DateTime $dateExported
     *
     * @return Purchase
     */
    public function setDateExported($dateExported)
    {
        $this->dateExported = $dateExported;

        return $this;
    }

    /**
     * Get dateExported
     *
     * @return \DateTime
     */
    public function getDateExported()
    {
        return $this->dateExported;
    }

    /**
     * Get dateImported
     *
     * @return \DateTime
     */
    public function getDateImported()
    {
        return $this->dateImported;
    }

    /**
     * Set dateImported
     *
     * @param \DateTime $dateImported
     *
     * @return Purchase
     */
    public function setDateImported($dateImported)
    {
        $this->dateImported = $dateImported;

        return $this;
    }

    /**
     * Set matchedImportedTransaction
     *
     * @param \AppBundle\Entity\ImportedTransaction $matchedImportedTransaction
     *
     * @return Purchase
     */
    public function setMatchedImportedTransaction(\AppBundle\Entity\ImportedTransaction $matchedImportedTransaction = null)
    {
        $this->matchedImportedTransaction = $matchedImportedTransaction;

        return $this;
    }

    /**
     * Get matchedImportedTransaction
     *
     * @return \AppBundle\Entity\ImportedTransaction
     */
    public function getMatchedImportedTransaction()
    {
        return $this->matchedImportedTransaction;
    }
    
    public function getAmount(){
        $items = $this->purchaseItems;
        $total = 0;
        foreach($items as $pi){
            $total += $pi->getAmount();
        }
        return number_format(floatval($total) + floatval($this->getSalesTax()), 2, '.', '');
    }

    /**
     * Set salesTax
     *
     * @param string $salesTax
     *
     * @return Purchase
     */
    public function setSalesTax($salesTax)
    {
        $this->salesTax = $salesTax;

        return $this;
    }

    /**
     * Get salesTax
     *
     * @return string
     */
    public function getSalesTax()
    {
        return $this->salesTax;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Purchase
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set totalAmount
     *
     * @param string $totalAmount
     *
     * @return Purchase
     */
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    /**
     * Get totalAmount
     *
     * @return string
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * Set approver.
     *
     * @param \AppBundle\Entity\Employee|null $approver
     *
     * @return Purchase
     */
    public function setApprover(\AppBundle\Entity\Employee $approver = null)
    {
        $this->approver = $approver;

        return $this;
    }

    /**
     * Get approver.
     *
     * @return \AppBundle\Entity\Employee|null
     */
    public function getApprover()
    {
        return $this->approver;
    }

    /**
     * Set decliner.
     *
     * @param \AppBundle\Entity\Employee|null $decliner
     *
     * @return Purchase
     */
    public function setDecliner(\AppBundle\Entity\Employee $decliner = null)
    {
        $this->decliner = $decliner;

        return $this;
    }

    /**
     * Get decliner.
     *
     * @return \AppBundle\Entity\Employee|null
     */
    public function getDecliner()
    {
        return $this->decliner;
    }

    /**
     * Set isOverrideSalesTax.
     *
     * @param bool $isOverrideSalesTax
     *
     * @return Purchase
     */
    public function setIsOverrideSalesTax($isOverrideSalesTax)
    {
        $this->isOverrideSalesTax = $isOverrideSalesTax;

        return $this;
    }

    /**
     * Get isOverrideSalesTax.
     *
     * @return bool
     */
    public function getIsOverrideSalesTax()
    {
        return $this->isOverrideSalesTax;
    }

    /**
     * Set vendor
     *
     * @param \AppBundle\Entity\Vendor $vendor
     *
     * @return Vendor
     */
    public function setVendor(\AppBundle\Entity\Vendor $vendor = null)
    {
        $this->vendor = $vendor;
    
        return $this;
    }

    /**
     * Get vendor
     *
     * @return \AppBundle\Entity\Vendor
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * Set isImportedToQuickbooks
     *
     * @param boolean $isImportedToQuickbooks
     *
     * @return Purchase
     */
    public function setIsImportedToQuickbooks($isImportedToQuickbooks)
    {
        $this->isImportedToQuickbooks = $isImportedToQuickbooks;

        return $this;
    }

    /**
     * Get isImportedToQuickbooks
     *
     * @return boolean
     */
    public function getIsImportedToQuickbooks()
    {
        return $this->isImportedToQuickbooks;
    }

    /**
     * Get qbImport
     *
     * @return boolean
     */
    public function getQbImport()
    {
        return $this->qbImport;
    }

    /**
     * Set qbImport
     *
     */
    public function setQbImport($qbImport)
    {
        $this->qbImport = $qbImport;
    }
}
