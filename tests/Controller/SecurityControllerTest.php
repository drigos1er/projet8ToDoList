<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    /**
     * Login page display test.
     */
    public function testLoginPage()
    {
        $clt = static::createClient();
        $clt->request('GET', '/login');
        $this->assertResponseStatusCodeSame(200);
    }

    /**
     * error credential test.
     */
    public function testErrorLogin()
    {
        $clt = static::createClient();
        $crawler = $clt->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form(['_username' => 'usert2', '_password' => 'usert2']);
        $clt->submit($form);
        $this->assertResponseRedirects();
        $clt->followRedirect();
        $this->assertSelectorExists('.alert.alert-danger');
    }

    /**
     * correct credentials test.
     */
    public function testSuccessLogin()
    {
        $clt = static::createClient();
        $crawler = $clt->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form(['_username' => 'usert2', '_password' => 'usert']);
        $clt->submit($form);
        $this->assertResponseRedirects();
        $clt->followRedirect();
        $this->assertSelectorTextContains('h1', "Bienvenue sur Todo List, l'application vous permettant de gérer l'ensemble de vos tâches sans effort !");
    }
}
