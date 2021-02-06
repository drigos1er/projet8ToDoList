<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Tests\AutTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends WebTestCase
{
    use AutTrait;


    public function testListUser()
    {
        $clt = static::createAuthenticatedUser();
        $em = $clt->getContainer()->get('doctrine.orm.entity_manager');
        $users = $em->getRepository(User::class)->findAll();
        $clt->request('GET', '/userarea/listuser', ['user' => $users]);

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }



    public function testListUserRestricted()
    {
        $clt = static::createClient();
        $clt->request('GET', '/userarea/listuser');

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $clt->followRedirect();
        $this->assertRouteSame('security_login');
    }

    public function testCreateUserisRestricted()
    {
        $clt = static::createClient();
        $clt->request('GET', '/userarea/createuser');
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $clt->followRedirect();
        $this->assertRouteSame('security_login');
    }




    public function testCreateUser()
    {
        $clt = static::createAuthenticatedUser();
        $crawler = $clt->request('GET', '/userarea/createuser');

        $f = $crawler->selectButton('Ajouter')->form();
        $f['user[username]'] = 'user5';
        $f['user[password][first]'] = 'user5';
        $f['user[password][second]'] = 'user5';
        $f['user[email]'] = 'user5@ci.ci';
        $f['user[userrole]'] = '2';
        $clt->submit($f);
        $this->assertResponseRedirects();
        $clt->followRedirect();
        $this->assertRouteSame('todolist_listuser');
    }



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
