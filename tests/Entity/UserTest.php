<?php

namespace App\Tests\Entity;

use App\Entity\User;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{


    public function testCreateUserValid()
    {
        //   $this->loadFixtureFiles([dirname(__DIR__).'/Fixtures/users.yaml']);

        $usert = new User();
        $usert->setPassword('usert');
        $usert->setUsername('usert3');
        $usert->setEmail('usert3@test.ci');
        $usert->setUserrole('2');
        self::bootKernel();
        $error = self::$container->get('validator')->validate($usert);
        $this->assertCount(0, $error);
    }
}
