<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {



        return $this->render('security/login.html.twig', [
            'error' =>$authenticationUtils->getLastAuthenticationError(),
            'last_username' =>$authenticationUtils->getLastUsername(),
            'current_menu'=>'login'

        ]);




    }


    public function loginCheck()
    {
        // This code is never executed.
    }


    public function logoutCheck()
    {
        // This code is never executed.
    }
}
