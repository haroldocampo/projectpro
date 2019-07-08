<?php
namespace Tests\AppBundle\Entity;

use AppBundle\Entity\ReminderJob;
use PHPUnit\Framework\TestCase;
class ReminderJobTest extends TestCase
{        
    public function testAddDay()
    {        
        $day = ReminderJob::$DAY_MONDAY;
        $job = new ReminderJob;
        $job->addDay($day);
        $this->assertContains($day,$job->getDays());
    }  
    public function testAddMultipleDay()
    {        
        $day = ReminderJob::$DAY_MONDAY;
        $day2 = ReminderJob::$DAY_TUESDAY;
        $job = new ReminderJob;
        $job->addDay($day);
        $job->addDay($day2);
        $this->assertEquals(2,count($job->getDays()));
    }  
    public function testAddDuplicateDay()
    {        
        $day = ReminderJob::$DAY_MONDAY;
        $day2 = ReminderJob::$DAY_MONDAY;
        $job = new ReminderJob;
        $job->addDay($day);
        $job->addDay($day2);
        $this->assertEquals(1,count($job->getDays()));
    }  
    public function testRemoveDay()
    {        
        $day = ReminderJob::$DAY_MONDAY;
        $job = new ReminderJob;
        $job->addDay($day);
        $job->removeDay($day);
        $this->assertEquals(0,count($job->getDays()));
    }  
    public function testRemoveMultipleDay()
    {        
        $day = ReminderJob::$DAY_MONDAY;
        $day2 = ReminderJob::$DAY_TUESDAY;
        $day3 = ReminderJob::$DAY_WEDNESDAY;
        $job = new ReminderJob;
        $job->addDay($day);
        $job->addDay($day2);
        $job->addDay($day3);
        $job->removeDay($day2);
        $this->assertContains($day,$job->getDays());
        $this->assertContains($day3,$job->getDays());
        $this->assertNotContains($day2,$job->getDays());
    }  
    public function testSetDays()
    {        
        $day = ReminderJob::$DAY_MONDAY;
        $day2 = ReminderJob::$DAY_TUESDAY;
        $day3 = ReminderJob::$DAY_WEDNESDAY;
        $days = array();
        $days [] = $day;
        $days [] = $day2;
        $days [] = $day3;
        $job = new ReminderJob;
        $job->setDays($days);
        $this->assertEquals($days,$job->getDays());
    }  
    public function testHasDayTrue()
    {        
        $day = ReminderJob::$DAY_MONDAY;
        $job = new ReminderJob;
        $job->addDay($day);        
        $this->assertTrue($job->hasDay(ReminderJob::$DAY_MONDAY));
    }  
    public function testHasDayFalse()
    {        
        $day = ReminderJob::$DAY_TUESDAY;
        $job = new ReminderJob;
        $job->addDay($day);        
        $this->assertFalse($job->hasDay(ReminderJob::$DAY_MONDAY));
    }
    public function testClearDays()
    {        
        $day = ReminderJob::$DAY_TUESDAY;
        $job = new ReminderJob;
        $job->addDay($day);
        $job->clearDays();        
        $this->assertEmpty($job->getDays());
    }  
    public function testSetCompany()
    {        
        $company = new \AppBundle\Entity\Company;
        $job = new ReminderJob;
        $job->setCompany($company);        
        $this->assertEquals($company,$job->getCompany());
    }  
    public function testSetType()
    {        
        $type = 'type';
        $job = new ReminderJob;
        $job->setType($type);        
        $this->assertEquals($type, $job->getType());
    }
    public function testSetSender()
    {        
        $sender = new \AppBundle\Entity\User;
        $job = new ReminderJob;
        $job->setSender($sender);        
        $this->assertEquals($sender, $job->getSender());
    }  
      

}