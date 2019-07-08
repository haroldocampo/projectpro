<?php
/**
 * Created by PhpStorm.
 * User: marksegalle
 * Date: 01/10/2017
 * Time: 6:52 PM
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReminderJobRepository")
 * @ORM\Table(name="reminder_job")
 * @ORM\HasLifecycleCallbacks
 * @Serializer\ExclusionPolicy("all")
 */
class ReminderJob
{

    static public $TYPE_APPROVER = "TYPE_APPROVER";
    static public $TYPE_PURCHASER = "TYPE_PURCHASER";

    static public $DAY_MONDAY = "DAY_MONDAY";
    static public $DAY_TUESDAY = "DAY_TUESDAY";
    static public $DAY_WEDNESDAY = "DAY_WEDNESDAY";
    static public $DAY_THURSDAY = "DAY_THURSDAY";
    static public $DAY_FRIDAY = "DAY_FRIDAY";

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Serializer\Expose
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Company", inversedBy="reminderJobs")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     */
    protected $company;

    /**
     * @ORM\Column(type="string")
     */
    protected $type;

    /**
     * @ORM\Column(type="array")
     */
    protected $days;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="sender_id", referencedColumnName="id")
     */
    protected $sender;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->days = array();
    }

    // $days functions

    /**
     * @param $day
     * @return $this
     */
    public function addDay($day)
    {
        $day = strtoupper($day);

        if (!in_array($day, $this->days, true)) {
            $this->days[] = $day;
        }

        return $this;
    }

    /**
     * @param $day
     * @return $this
     */
    public function removeDay($day) {
        if (false !== $key = array_search(strtoupper($day), $this->days, true)) {
            unset($this->days[$key]);
            $this->days = array_values($this->days);
        }

        return $this;
    }

    /**
     * Get days
     *
     * @return array
     */
    public function getDays()
    {
        $days = $this->days;

        return array_unique($days);
    }

    /**
     * @param $day
     * @return bool
     */
    public function hasDay($day)
    {
        return in_array(strtoupper($day), $this->getDays(), true);
    }

    public function clearDays() {
        $this->days = array();
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
     * Set company
     *
     * @param \AppBundle\Entity\Company $company
     *
     * @return ReminderJob
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
     * Set types
     *
     * @param string $type
     *
     * @return ReminderJob
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get types
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set days
     *
     * @param array $days
     *
     * @return ReminderJob
     */
    public function setDays($days)
    {
        $this->days = $days;

        return $this;
    }

    /**
     * Set sender
     *
     * @param \AppBundle\Entity\User $sender
     *
     * @return ReminderJob
     */
    public function setSender(\AppBundle\Entity\User $sender = null)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * Get sender
     *
     * @return \AppBundle\Entity\User
     */
    public function getSender()
    {
        return $this->sender;
    }
}
