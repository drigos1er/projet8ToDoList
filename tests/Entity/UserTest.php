<?php

namespace App\Tests\Entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{
    /**
     * Validation adding user test.
     */
    public function testCreateUserValid()
    {
        $usert = new User();
        $usert->setPassword('usert13');
        $usert->setUsername('usert13');
        $usert->setEmail('usert13@test.ci');
        $usert->setUserrole('2');
        self::bootKernel();
        $error = self::$container->get('validator')->validate($usert);
        $this->assertCount(0, $error);
    }
}
