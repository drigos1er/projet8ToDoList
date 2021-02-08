<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends AbstractController
{
    /**
     * Liste de TASK.
     *
     * @return Response
     */
    public function listTask(TaskRepository $taskRepository)
    {
        return $this->render('task/list.html.twig', ['tasks' => $taskRepository->findAll()]);
    }

    /**
     * Liste de TASK DONE.
     *
     * @return Response
     */
    public function listTaskdone(TaskRepository $taskRepository)
    {
        return $this->render('task/list.html.twig', ['tasks' => $taskRepository->findBy(['isDone' => 1])]);
    }

    /**
     * Liste de TASK IS NOT DONE.
     *
     * @return Response
     */
    public function listTaskisnotdone(TaskRepository $taskRepository)
    {
        return $this->render('task/list.html.twig', ['tasks' => $taskRepository->findBy(['isDone' => 0])]);
    }

    /**
     * Création de TASK.
     */
    public function createTask(Request $request)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $task->setUsers($this->getUser());

            $em->persist($task);
            $em->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('todolist_listtask');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * EDIT TASK.
     */
    public function editTask(Request $request, $taskid, TaskRepository $taskRepository)
    {
        $task = $taskRepository->findOneById($taskid);

        if ($this->getUser()->getId() != $task->getUsers()->getId()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('error', 'Desolè vous n\'êtes pas autorisé à modifier cette tâche.');

            return $this->redirectToRoute('todolist_listtask');
        }

        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('todolist_listtask');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    /**
     * Marquage de Task.
     */
    public function toggleTask(Task $task)
    {
        $task->toggle(!$task->isDone());
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('todolist_listtask');
    }

    /**
     * Delete Task.
     */
    public function deleteTask(TaskRepository $taskRepository, $taskid)
    {
        $task = $taskRepository->findOneById($taskid);

        if ($this->getUser()->getId() != $task->getUsers()->getId()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('error', 'Desolè vous n\'êtes pas autorisé à supprimer cette tâche.');

            return $this->redirectToRoute('todolist_listtask');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();

        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('todolist_listtask');
    }
}
