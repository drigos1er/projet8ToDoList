<?php

namespace App\Tests;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

trait AutTrait
{
    public static function createAuthenticatedUser(): KernelBrowser
    {
        $clt = static::createClient();

        $session = $clt->getContainer()->get('session');

        $firewall = 'main';
        $emng = $clt->getContainer()->get('doctrine.orm.entity_manager');
        $user = $emng->getRepository(User::class)->findOneById(1);

        $token = new UsernamePasswordToken($user, $user->getPassword(), $firewall, $user->getRoles());
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $clt->getCookieJar()->set($cookie);

        return $clt;
    }
}
