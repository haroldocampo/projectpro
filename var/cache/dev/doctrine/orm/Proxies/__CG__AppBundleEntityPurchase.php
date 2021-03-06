<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Purchase extends \AppBundle\Entity\Purchase implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = [];



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return ['__isInitialized__', 'id', 'dateOfPurchase', 'dateCreated', 'status', 'comments', 'dateApproved', 'dateDeclined', 'receiptImageUrl', 'dateExported', 'dateImported', 'salesTax', 'totalAmount', 'purchaseItems', 'project', 'purchaser', 'approver', 'decliner', 'paymentType', 'matchedImportedTransaction', 'isOverrideSalesTax', 'isImportedToQuickbooks', 'vendor', 'qbImport', '' . "\0" . 'AppBundle\\Entity\\Purchase' . "\0" . 'image', '' . "\0" . 'AppBundle\\Entity\\Purchase' . "\0" . 'imageFile', '' . "\0" . 'AppBundle\\Entity\\Purchase' . "\0" . 'updatedAt'];
        }

        return ['__isInitialized__', 'id', 'dateOfPurchase', 'dateCreated', 'status', 'comments', 'dateApproved', 'dateDeclined', 'receiptImageUrl', 'dateExported', 'dateImported', 'salesTax', 'totalAmount', 'purchaseItems', 'project', 'purchaser', 'approver', 'decliner', 'paymentType', 'matchedImportedTransaction', 'isOverrideSalesTax', 'isImportedToQuickbooks', 'vendor', 'qbImport', '' . "\0" . 'AppBundle\\Entity\\Purchase' . "\0" . 'image', '' . "\0" . 'AppBundle\\Entity\\Purchase' . "\0" . 'imageFile', '' . "\0" . 'AppBundle\\Entity\\Purchase' . "\0" . 'updatedAt'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Purchase $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', []);
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', []);
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function updatedTimestamps()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'updatedTimestamps', []);

        return parent::updatedTimestamps();
    }

    /**
     * {@inheritDoc}
     */
    public function setImageFile(\Symfony\Component\HttpFoundation\File\File $image = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setImageFile', [$image]);

        return parent::setImageFile($image);
    }

    /**
     * {@inheritDoc}
     */
    public function getImageFile()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getImageFile', []);

        return parent::getImageFile();
    }

    /**
     * {@inheritDoc}
     */
    public function setImage($image)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setImage', [$image]);

        return parent::setImage($image);
    }

    /**
     * {@inheritDoc}
     */
    public function getImage()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getImage', []);

        return parent::getImage();
    }

    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', []);

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function setDateOfPurchase($dateOfPurchase)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDateOfPurchase', [$dateOfPurchase]);

        return parent::setDateOfPurchase($dateOfPurchase);
    }

    /**
     * {@inheritDoc}
     */
    public function getDateOfPurchase()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDateOfPurchase', []);

        return parent::getDateOfPurchase();
    }

    /**
     * {@inheritDoc}
     */
    public function setDateCreated($dateCreated)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDateCreated', [$dateCreated]);

        return parent::setDateCreated($dateCreated);
    }

    /**
     * {@inheritDoc}
     */
    public function getDateCreated()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDateCreated', []);

        return parent::getDateCreated();
    }

    /**
     * {@inheritDoc}
     */
    public function setStatus($status)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setStatus', [$status]);

        return parent::setStatus($status);
    }

    /**
     * {@inheritDoc}
     */
    public function getStatus()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStatus', []);

        return parent::getStatus();
    }

    /**
     * {@inheritDoc}
     */
    public function setComments($comments)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setComments', [$comments]);

        return parent::setComments($comments);
    }

    /**
     * {@inheritDoc}
     */
    public function getComments()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getComments', []);

        return parent::getComments();
    }

    /**
     * {@inheritDoc}
     */
    public function addPurchaseItem(\AppBundle\Entity\PurchaseItem $purchaseItem)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addPurchaseItem', [$purchaseItem]);

        return parent::addPurchaseItem($purchaseItem);
    }

    /**
     * {@inheritDoc}
     */
    public function removePurchaseItem(\AppBundle\Entity\PurchaseItem $purchaseItem)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removePurchaseItem', [$purchaseItem]);

        return parent::removePurchaseItem($purchaseItem);
    }

    /**
     * {@inheritDoc}
     */
    public function getPurchaseItems()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPurchaseItems', []);

        return parent::getPurchaseItems();
    }

    /**
     * {@inheritDoc}
     */
    public function setProject(\AppBundle\Entity\Project $project = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setProject', [$project]);

        return parent::setProject($project);
    }

    /**
     * {@inheritDoc}
     */
    public function getProject()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getProject', []);

        return parent::getProject();
    }

    /**
     * {@inheritDoc}
     */
    public function setPurchaser(\AppBundle\Entity\Employee $purchaser = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPurchaser', [$purchaser]);

        return parent::setPurchaser($purchaser);
    }

    /**
     * {@inheritDoc}
     */
    public function getPurchaser()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPurchaser', []);

        return parent::getPurchaser();
    }

    /**
     * {@inheritDoc}
     */
    public function setReceiptImageUrl($receiptImageUrl)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setReceiptImageUrl', [$receiptImageUrl]);

        return parent::setReceiptImageUrl($receiptImageUrl);
    }

    /**
     * {@inheritDoc}
     */
    public function getReceiptImageUrl()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getReceiptImageUrl', []);

        return parent::getReceiptImageUrl();
    }

    /**
     * {@inheritDoc}
     */
    public function setPaymentType(\AppBundle\Entity\PaymentType $paymentType = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPaymentType', [$paymentType]);

        return parent::setPaymentType($paymentType);
    }

    /**
     * {@inheritDoc}
     */
    public function getPaymentType()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPaymentType', []);

        return parent::getPaymentType();
    }

    /**
     * {@inheritDoc}
     */
    public function setDateApproved($dateApproved)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDateApproved', [$dateApproved]);

        return parent::setDateApproved($dateApproved);
    }

    /**
     * {@inheritDoc}
     */
    public function getDateApproved()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDateApproved', []);

        return parent::getDateApproved();
    }

    /**
     * {@inheritDoc}
     */
    public function setDateDeclined($dateDeclined)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDateDeclined', [$dateDeclined]);

        return parent::setDateDeclined($dateDeclined);
    }

    /**
     * {@inheritDoc}
     */
    public function getDateDeclined()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDateDeclined', []);

        return parent::getDateDeclined();
    }

    /**
     * {@inheritDoc}
     */
    public function setDateExported($dateExported)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDateExported', [$dateExported]);

        return parent::setDateExported($dateExported);
    }

    /**
     * {@inheritDoc}
     */
    public function getDateExported()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDateExported', []);

        return parent::getDateExported();
    }

    /**
     * {@inheritDoc}
     */
    public function getDateImported()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDateImported', []);

        return parent::getDateImported();
    }

    /**
     * {@inheritDoc}
     */
    public function setDateImported($dateImported)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDateImported', [$dateImported]);

        return parent::setDateImported($dateImported);
    }

    /**
     * {@inheritDoc}
     */
    public function setMatchedImportedTransaction(\AppBundle\Entity\ImportedTransaction $matchedImportedTransaction = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMatchedImportedTransaction', [$matchedImportedTransaction]);

        return parent::setMatchedImportedTransaction($matchedImportedTransaction);
    }

    /**
     * {@inheritDoc}
     */
    public function getMatchedImportedTransaction()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMatchedImportedTransaction', []);

        return parent::getMatchedImportedTransaction();
    }

    /**
     * {@inheritDoc}
     */
    public function getAmount()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAmount', []);

        return parent::getAmount();
    }

    /**
     * {@inheritDoc}
     */
    public function setSalesTax($salesTax)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setSalesTax', [$salesTax]);

        return parent::setSalesTax($salesTax);
    }

    /**
     * {@inheritDoc}
     */
    public function getSalesTax()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getSalesTax', []);

        return parent::getSalesTax();
    }

    /**
     * {@inheritDoc}
     */
    public function setUpdatedAt($updatedAt)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUpdatedAt', [$updatedAt]);

        return parent::setUpdatedAt($updatedAt);
    }

    /**
     * {@inheritDoc}
     */
    public function getUpdatedAt()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUpdatedAt', []);

        return parent::getUpdatedAt();
    }

    /**
     * {@inheritDoc}
     */
    public function setTotalAmount($totalAmount)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTotalAmount', [$totalAmount]);

        return parent::setTotalAmount($totalAmount);
    }

    /**
     * {@inheritDoc}
     */
    public function getTotalAmount()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTotalAmount', []);

        return parent::getTotalAmount();
    }

    /**
     * {@inheritDoc}
     */
    public function setApprover(\AppBundle\Entity\Employee $approver = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setApprover', [$approver]);

        return parent::setApprover($approver);
    }

    /**
     * {@inheritDoc}
     */
    public function getApprover()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getApprover', []);

        return parent::getApprover();
    }

    /**
     * {@inheritDoc}
     */
    public function setDecliner(\AppBundle\Entity\Employee $decliner = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDecliner', [$decliner]);

        return parent::setDecliner($decliner);
    }

    /**
     * {@inheritDoc}
     */
    public function getDecliner()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDecliner', []);

        return parent::getDecliner();
    }

    /**
     * {@inheritDoc}
     */
    public function setIsOverrideSalesTax($isOverrideSalesTax)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIsOverrideSalesTax', [$isOverrideSalesTax]);

        return parent::setIsOverrideSalesTax($isOverrideSalesTax);
    }

    /**
     * {@inheritDoc}
     */
    public function getIsOverrideSalesTax()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIsOverrideSalesTax', []);

        return parent::getIsOverrideSalesTax();
    }

    /**
     * {@inheritDoc}
     */
    public function setVendor(\AppBundle\Entity\Vendor $vendor = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setVendor', [$vendor]);

        return parent::setVendor($vendor);
    }

    /**
     * {@inheritDoc}
     */
    public function getVendor()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getVendor', []);

        return parent::getVendor();
    }

    /**
     * {@inheritDoc}
     */
    public function setIsImportedToQuickbooks($isImportedToQuickbooks)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIsImportedToQuickbooks', [$isImportedToQuickbooks]);

        return parent::setIsImportedToQuickbooks($isImportedToQuickbooks);
    }

    /**
     * {@inheritDoc}
     */
    public function getIsImportedToQuickbooks()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIsImportedToQuickbooks', []);

        return parent::getIsImportedToQuickbooks();
    }

    /**
     * {@inheritDoc}
     */
    public function getQbImport()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getQbImport', []);

        return parent::getQbImport();
    }

    /**
     * {@inheritDoc}
     */
    public function setQbImport($qbImport)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setQbImport', [$qbImport]);

        return parent::setQbImport($qbImport);
    }

}
