<?php

namespace Proxies\__CG__\AppBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class PaymentType extends \AppBundle\Entity\PaymentType implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', 'id', 'name', 'dateCreated', 'enabled', 'employeePaymentTypes', 'company', 'purchases', 'transactionType'];
        }

        return ['__isInitialized__', 'id', 'name', 'dateCreated', 'enabled', 'employeePaymentTypes', 'company', 'purchases', 'transactionType'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (PaymentType $proxy) {
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
    public function setName($name)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setName', [$name]);

        return parent::setName($name);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getName', []);

        return parent::getName();
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
    public function setCompany(\AppBundle\Entity\Company $company = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCompany', [$company]);

        return parent::setCompany($company);
    }

    /**
     * {@inheritDoc}
     */
    public function getCompany()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCompany', []);

        return parent::getCompany();
    }

    /**
     * {@inheritDoc}
     */
    public function addPurchase(\AppBundle\Entity\Purchase $purchase)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addPurchase', [$purchase]);

        return parent::addPurchase($purchase);
    }

    /**
     * {@inheritDoc}
     */
    public function getHasEmployeePaymentTypes()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getHasEmployeePaymentTypes', []);

        return parent::getHasEmployeePaymentTypes();
    }

    /**
     * {@inheritDoc}
     */
    public function getHasPurchases()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getHasPurchases', []);

        return parent::getHasPurchases();
    }

    /**
     * {@inheritDoc}
     */
    public function removePurchase(\AppBundle\Entity\Purchase $purchase)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removePurchase', [$purchase]);

        return parent::removePurchase($purchase);
    }

    /**
     * {@inheritDoc}
     */
    public function getPurchases()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPurchases', []);

        return parent::getPurchases();
    }

    /**
     * {@inheritDoc}
     */
    public function setEnabled($enabled)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEnabled', [$enabled]);

        return parent::setEnabled($enabled);
    }

    /**
     * {@inheritDoc}
     */
    public function getEnabled()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEnabled', []);

        return parent::getEnabled();
    }

    /**
     * {@inheritDoc}
     */
    public function addEmployeePaymentType(\AppBundle\Entity\EmployeePaymentType $employeePaymentType)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addEmployeePaymentType', [$employeePaymentType]);

        return parent::addEmployeePaymentType($employeePaymentType);
    }

    /**
     * {@inheritDoc}
     */
    public function removeEmployeePaymentType(\AppBundle\Entity\EmployeePaymentType $employeePaymentType)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeEmployeePaymentType', [$employeePaymentType]);

        return parent::removeEmployeePaymentType($employeePaymentType);
    }

    /**
     * {@inheritDoc}
     */
    public function getEmployeePaymentTypes()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEmployeePaymentTypes', []);

        return parent::getEmployeePaymentTypes();
    }

    /**
     * {@inheritDoc}
     */
    public function setTransactionType(\AppBundle\Entity\TransactionType $transactionType = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTransactionType', [$transactionType]);

        return parent::setTransactionType($transactionType);
    }

    /**
     * {@inheritDoc}
     */
    public function getTransactionType()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTransactionType', []);

        return parent::getTransactionType();
    }

}