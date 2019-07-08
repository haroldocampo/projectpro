<?php

/**
 * Created by PhpStorm.
 * User: marks
 * Date: 9/14/2017
 * Time: 5:04 PM
 */
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\Table(name="fos_user")
 * @Serializer\ExclusionPolicy("all")
 */
class User extends BaseUser
{
    const ROLE_ADMIN = 'ROLE_ADMIN';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Serializer\Expose
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Serializer\Expose
     */
    protected $lastName;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $streetAddress;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    protected $town;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $state;

    /**
     * @ORM\Column(type="string", length=55, nullable=true)
     */
    protected $country;

    /**
     * @ORM\Column(type="string", length=254, nullable=true)
     */
    protected $accountantEmail;

    /**
     * @ORM\Column(type="string", length=25, nullable=true)
     */
    protected $passwordSetToken;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isDoneCostCodeInstructions = false;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $isDoneWizard = false;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Employee", mappedBy="user")
     */
    protected $employments;

    public function __construct()
    {
        parent::__construct();
        // your own logic
        $this->employments = new ArrayCollection();
    }

    // Bypassing username
    public function setEmail($email)
    {
        $email = is_null($email) ? '' : $email;
        parent::setEmail($email);
        $this->setUsername($email);

        return $this;
    }

    // Bypass form submitted password
//    public function setPlainPassword($password = "thisIsProjectProSuperPassword")
//    {
//        $this->plainPassword = $password;
//
//        return $this;
//    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get Company Employment
     *
     * @return string
     */
    public function getCompanyEmployment($companyId)
    {
        foreach($employments as $e){
            if($e->getCompany()->getId() == $companyId){
                return $e;
            }
        }
        
        throw $this->createNotFoundException('Employment not found based on companyId passed.');
    }
        
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set streetAddress
     *
     * @param string $streetAddress
     *
     * @return User
     */
    public function setStreetAddress($streetAddress)
    {
        $this->streetAddress = $streetAddress;

        return $this;
    }

    /**
     * Get streetAddress
     *
     * @return string
     */
    public function getStreetAddress()
    {
        return $this->streetAddress;
    }

    /**
     * Set town
     *
     * @param string $town
     *
     * @return User
     */
    public function setTown($town)
    {
        $this->town = $town;

        return $this;
    }

    /**
     * Get town
     *
     * @return string
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * Set state
     *
     * @param string $state
     *
     * @return User
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return User
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Add employment
     *
     * @param \AppBundle\Entity\Employee $employment
     *
     * @return User
     */
    public function addEmployment(\AppBundle\Entity\Employee $employment)
    {
        $this->employments[] = $employment;

        return $this;
    }

    /**
     * Remove employment
     *
     * @param \AppBundle\Entity\Employee $employment
     */
    public function removeEmployment(\AppBundle\Entity\Employee $employment)
    {
        $this->employments->removeElement($employment);
    }

    /**
     * Get employments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmployments()
    {
        return $this->employments;
    }
    /**
     * Set emailSetToken
     *
     * @param string $passwordSetToken
     *
     * @return User
     */
    public function setPasswordSetToken($passwordSetToken)
    {
        $this->passwordSetToken = $passwordSetToken;

        return $this;
    }

    /**
     * Get emailSetToken
     *
     * @return string
     */
    public function getPasswordSetToken()
    {
        return $this->passwordSetToken;
    }

    /**
     * Set isDoneCostCodeInstructions
     *
     * @param boolean $isDoneCostCodeInstructions
     *
     * @return User
     */
    public function setIsDoneCostCodeInstructions($isDoneCostCodeInstructions)
    {
        $this->isDoneCostCodeInstructions = $isDoneCostCodeInstructions;

        return $this;
    }

    /**
     * Get isDoneCostCodeInstructions
     *
     * @return boolean
     */
    public function getIsDoneCostCodeInstructions()
    {
        return $this->isDoneCostCodeInstructions;
    }

    /**
     * Set isDoneWizard
     *
     * @param boolean $isDoneWizard
     *
     * @return User
     */
    public function setIsDoneWizard($isDoneWizard)
    {
        $this->isDoneWizard = $isDoneWizard;

        return $this;
    }

    /**
     * Get isDoneWizard
     *
     * @return boolean
     */
    public function getIsDoneWizard()
    {
        return $this->isDoneWizard;
    }

    /**
     * Set accountantEmail
     *
     * @param string $accountantEmail
     *
     * @return User
     */
    public function setAccountantEmail($accountantEmail)
    {
        $this->accountantEmail = $accountantEmail;

        return $this;
    }

    /**
     * Get accountantEmail
     *
     * @return string
     */
    public function getAccountantEmail()
    {
        return $this->accountantEmail;
    }
}
