<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
/**
 * QbException
 *
 * @ORM\Table(name="qb_exception")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\QbExceptionRepository")
 * @ORM\HasLifecycleCallbacks
 * @Serializer\ExclusionPolicy("all")
 */
class QbException
{    
    // Mapped to the corresponding error codes.
    public static $error_messages = ['Missing Transaction Type', 
    'Vendor not found', 'Cost Code not found', 'Project not found', 
    'Duplicate projects in QB', 'Payment type not found'];
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Expose
     */
    protected $id;

    /**
     * @var int
     *
     * @ORM\Column(name="errorCode", type="integer")
     * @Serializer\Expose
     */
    protected $errorCode;

    /**
     * @var string
     *
     * @ORM\Column(name="errorMessage", type="string", length=512, nullable=true)
     * @Serializer\Expose
     */
    protected $errorMessage;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PurchaseItem", inversedBy="qbExceptions")
     * @ORM\JoinColumn(name="purchase_item_id", referencedColumnName="id")
     * @Serializer\Expose
     */
    protected $purchaseItem;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isResolved", type="boolean", length=255, nullable=true)
     * @Serializer\Expose
     */
    protected $isResolved = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isExported", type="boolean", length=255, nullable=true)
     * @Serializer\Expose
     */
    protected $isExported = false;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set errorCode
     *
     * @param integer $errorCode
     *
     * @return QbException
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;

        return $this;
    }

    /**
     * Get errorCode
     *
     * @return int
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * Set errorMessage
     *
     * @param string $errorMessage
     *
     * @return QbException
     */
    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;

        return $this;
    }

    /**
     * Get errorMessage
     *
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * Set purchaseItem
     *
     * @param string $purchaseItem
     *
     * @return QbException
     */
    public function setPurchaseItem($purchaseItem)
    {
        $this->purchaseItem = $purchaseItem;

        return $this;
    }

    /**
     * Get purchaseItem
     *
     * @return string
     */
    public function getPurchaseItem()
    {
        return $this->purchaseItem;
    }
        
    /**
     * Set isResolved
     *
     * @param boolean $isResolved
     * 
     * @return QbException    
     */
    public function setIsResolved($isResolved)
    {
        $this->isResolved = $isResolved;

        return $this;
    }

    /**
     * Get isResolved
     *
     * @return boolean
     */
    public function getIsResolved()
    {
        return $this->isResolved;
    }    
    /**
     * Set isExported
     *
     * @param boolean $isExported
     * 
     * @return QbException
     */
    public function setIsExported($isExported)
    {
        $this->isExported = $isExported;
        return $this;
    }

    /**
     * Get isExported
     *
     * @return boolean
     */
    public function getIsExported()
    {
        return $this->isExported;
    }    
}
