<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    /**
     * Home page display test.
     */
    public function testIndex()
    {
        $clt = static::createClient();
        $clt->request('GET', '/');
        $this->assertResponseStatusCodeSame(200);
    }
}
