<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * user list.
     *
     * @return Response
     */
    public function listUser(UserRepository $userRepository)
    {
        return $this->render('user/list.html.twig', ['users' => $userRepository->findAll()]);
    }

    /**
     * Create a user.
     *
     * @return RedirectResponse|Response
     */
    public function createUser(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $ems = $this->getDoctrine()->getManager();

            $passwords = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($passwords);

            $ems->persist($user);
            $ems->flush();

            $lastids = $user->getId();

            $sqls = ' REPLACE INTO to_do_role_user VALUES (:roleid,:userid)  ';
            $paramss = ['roleid' => $form['userrole']->getData(), 'userid' => $lastids];

            $ems = $this->getDoctrine()->getManager();
            $stmts = $ems->getConnection()->prepare($sqls);
            $stmts->execute($paramss);

            $this->addFlash('success', "L'utilisateur a bien été ajouté.");

            return $this->redirectToRoute('todolist_listuser');
        }

        return $this->render('user/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * User edit.
     *
     * @return RedirectResponse|Response
     */
    public function editUser(User $user, Request $request, UserPasswordEncoderInterface $encoder)
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

    /**
     * Delete Task.
     *
     *
     * @param $taskid
     *
     * @return RedirectResponse
     */
    public function deleteUser(UserRepository $userRepository, $userid)
    {
        $user = $userRepository->findOneById($userid);

        if ('todoadm' == $user->getUsers()->getUsername()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('error', 'Desolè vous n\'êtes pas autorisé à supprimer cet utilisateur.');

            return $this->redirectToRoute('todolist_listuser');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        $this->addFlash('success', 'L\'utilisateur a bien été supprimé.');

        return $this->redirectToRoute('todolist_listuser');
    }
}
