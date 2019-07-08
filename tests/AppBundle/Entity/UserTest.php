<?php
namespace Tests\AppBundle\Entity;

use AppBundle\Entity\User;
use PHPUnit\Framework\TestCase;
class UserTest extends TestCase
{    
    public function testSetEmail()
    {
        $email = 'r@gmail.com';
        $user = new User();
        $user->setEmail($email);
        $this->assertEquals($email, $user->getEmail());
    }
    public function testSetFirstName()
    {
        $firstname = 'randy';
        $user = new User();
        $user->setFirstName($firstname);
        $this->assertEquals($firstname, $user->getFirstName());
    }
    public function testSetLastName()
    {
        $lastname = 'yu';
        $user = new User();
        $user->setLastName($lastname);
        $this->assertEquals($lastname, $user->getLastName());
    }
    public function testSetStreetAddress()
    {
        $lastname = 'Over the rainbow';
        $user = new User();
        $user->setLastName($lastname);
        $this->assertEquals($lastname, $user->getLastName());
    }
}