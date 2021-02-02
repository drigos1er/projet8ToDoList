<?php

namespace App\Tests\Controller;

use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{


    public function testIndex()
    {
        $clt = static::createClient();
        $clt->request('GET', '/');
        $this->assertResponseStatusCodeSame(200);
    }

}
