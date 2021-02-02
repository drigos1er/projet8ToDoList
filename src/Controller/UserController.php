<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    public function listUser(UserRepository $userRepository)
    {
        return $this->render('user/list.html.twig', ['users' => $userRepository->findAll()]);
    }

    public function createUser(Request $request, UserPasswordEncoderInterface $encoder, UserRepository $userRepository)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $em = $this->getDoctrine()->getManager();

            $password = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($password);

            $em->persist($user);
            $em->flush();

            $lastid = $user->getId();

            $sql = ' REPLACE INTO to_do_role_user VALUES (:roleid,:userid)  ';
            $params = ['roleid' => $form['userrole']->getData(), 'userid' => $lastid];

            $em = $this->getDoctrine()->getManager();
            $stmt = $em->getConnection()->prepare($sql);
            $stmt->execute($params);

            $this->addFlash('success', "L'utilisateur a bien été ajouté.");

            return $this->redirectToRoute('todolist_listuser');
        }

        return $this->render('user/create.html.twig', ['form' => $form->createView()]);
    }

    public function editUser(User $user, Request $request, UserPasswordEncoderInterface $encoder, UserRepository $userRepository)
    {
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $password = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($password);

            $em->persist($user);
            $em->flush();

            $lastid = $user->getId();

            $sql = ' REPLACE INTO to_do_role_user VALUES (:roleid,:userid)  ';
            $params = ['roleid' => $form['userrole']->getData(), 'userid' => $lastid];

            $em = $this->getDoctrine()->getManager();
            $stmt = $em->getConnection()->prepare($sql);
            $stmt->execute($params);

            $this->addFlash('success', "L'utilisateur a bien été modifié");

            return $this->redirectToRoute('todolist_listuser');
        }

        return $this->render('user/edit.html.twig', ['form' => $form->createView(), 'user' => $user]);
    }
}
