<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Tests\AutTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends WebTestCase
{
    use AutTrait;

    /**
     * List users page test.
     */
    public function testListUser()
    {
        $clt = static::createAuthenticatedUser();
        $em = $clt->getContainer()->get('doctrine.orm.entity_manager');
        $users = $em->getRepository(User::class)->findAll();
        $clt->request('GET', '/userarea/listuser', ['user' => $users]);

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    /**
     * Restricted access to the user list test.
     */
    public function testListUserRestricted()
    {
        $clt = static::createClient();
        $clt->request('GET', '/userarea/listuser');

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $clt->followRedirect();
        $this->assertRouteSame('security_login');
    }

    /**
     * Restricted access to create user test.
     */
    public function testCreateUserisRestricted()
    {
        $clt = static::createClient();
        $clt->request('GET', '/userarea/createuser');
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $clt->followRedirect();
        $this->assertRouteSame('security_login');
    }

    /**
     * Create user test.
     */
    public function testCreateUser()
    {
        $clt = static::createAuthenticatedUser();
        $crawler = $clt->request('GET', '/userarea/createuser');

        $f = $crawler->selectButton('Ajouter')->form();
        $f['user[username]'] = 'user8';
        $f['user[password][first]'] = 'user8';
        $f['user[password][second]'] = 'user8';
        $f['user[email]'] = 'user8@ci.ci';
        $f['user[userrole]'] = '2';
        $clt->submit($f);
        $this->assertResponseRedirects();
        $clt->followRedirect();
        $this->assertRouteSame('todolist_listuser');
    }

    /**
     * Edit user test.
     */
    public function testEditUser()
    {
        $clt = static::createAuthenticatedUser();
        $em = $clt->getContainer()->get('doctrine.orm.entity_manager');

        $user = $em->getRepository(User::class)->findOneById(2);

        $crawler = $clt->request('GET', '/userarea/edituser/'.$user->getId().'');
        $f = $crawler->selectButton('Modifier')->form();
        $f['user[username]'] = 'user7';
        $f['user[password][first]'] = 'user7';
        $f['user[password][second]'] = 'user7';
        $f['user[email]'] = 'user4@ci.ci';
        $f['user[userrole]'] = '2';
        $clt->submit($f);
        $this->assertResponseRedirects();
        $clt->followRedirect();
        $this->assertRouteSame('todolist_listuser');
    }
}
