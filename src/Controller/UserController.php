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
    public function editUser(UserRepository $userRepository, $userid, Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = $userRepository->findOneById($userid);

        if ('todoadm' == $user->getUsername()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('error', 'Desolè vous n\'êtes pas autorisé à modifier cet utilisateur.');

            return $this->redirectToRoute('todolist_listuser');
        }

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $ema = $this->getDoctrine()->getManager();

            $password = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($password);

            $ema->persist($user);
            $ema->flush();

            $lastid = $user->getId();

            $sql = ' REPLACE INTO to_do_role_user VALUES (:roleid,:userid)  ';
            $params = ['roleid' => $form['userrole']->getData(), 'userid' => $lastid];

            $ema = $this->getDoctrine()->getManager();
            $stmt = $ema->getConnection()->prepare($sql);
            $stmt->execute($params);

            $this->addFlash('success', "L'utilisateur a bien été modifié");

            return $this->redirectToRoute('todolist_listuser');
        }

        return $this->render('user/edit.html.twig', ['form' => $form->createView(), 'user' => $user]);
    }

    /**
     * Delete Task.
     *
     * @param $userid
     *
     * @return RedirectResponse
     */
    public function deleteUser(UserRepository $userRepository, $userid)
    {
        $user = $userRepository->findOneById($userid);

        if ('todoadm' == $user->getUsername()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('error', 'Desolè vous n\'êtes pas autorisé à supprimer cet utilisateur.');

            return $this->redirectToRoute('todolist_listuser');
        }

        $sql = ' DELETE FROM task WHERE users_id=:userid  ';
        $params = ['userid' => $userid];

        $entitym = $this->getDoctrine()->getManager();
        $stmt = $entitym->getConnection()->prepare($sql);
        $stmt->execute($params);

        $sql1 = ' DELETE FROM to_do_role_user WHERE user_id=:userid  ';
        $params1 = ['userid' => $userid];


        $stmt1 = $entitym->getConnection()->prepare($sql1);
        $stmt1->execute($params1);


        $entitym->remove($user);
        $entitym->flush();

        $this->addFlash('success', 'L\'utilisateur a bien été supprimé.');

        return $this->redirectToRoute('todolist_listuser');
    }
}
