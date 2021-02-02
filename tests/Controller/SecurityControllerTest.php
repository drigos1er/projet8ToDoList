<?php

namespace App\Tests\Controller;

use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    use FixturesTrait;

    public function testLoginPage()
    {
        $clt = static::createClient();
        $clt->request('GET', '/login');
        $this->assertResponseStatusCodeSame(200);
    }
/*
    public function testErrorLogin()
    {
        $clt = static::createClient();
        $crawler = $clt->request('GET', '/login');
        $f = $crawler->selectButton('Se connecter')->form(['_username' => 'usert2', '_password' => 'usert2']);
        $clt->submit($f);
        $this->assertResponseRedirects();
        $clt->followRedirect();
        $this->assertSelectorExists('.alert.alert-danger');
    }

    public function testSuccessLogin()
    {
        $this->loadFixtureFiles([dirname(__DIR__).'/Fixtures/users.yaml']);
        $clt = static::createClient();
        $crawler = $clt->request('GET', '/login');
        $f = $crawler->selectButton('Se connecter')->form(['_username' => 'usert2', '_password' => 'usert']);
        $clt->submit($f);
        $this->assertResponseRedirects();
i        $clt->followRedirect();
        $this->assertSelectorTextContains('h1', "Bienvenue sur Todo List, l'application vous permettant de gérer l'ensemble de vos tâches sans effort !");
    }
*/
}
