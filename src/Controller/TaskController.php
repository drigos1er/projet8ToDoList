<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends AbstractController
{
    /**
     * task list.
     *
     * @return Response
     */
    public function listTask(TaskRepository $taskRepository)
    {
        return $this->render('task/list.html.twig', ['tasks' => $taskRepository->findAll()]);
    }

    /**
     * task list done.
     *
     * @return Response
     */
    public function listTaskdone(TaskRepository $taskRepository)
    {
        return $this->render('task/list.html.twig', ['tasks' => $taskRepository->findBy(['isDone' => 1])]);
    }

    /**
     * task list not done.
     *
     * @return Response
     */
    public function listTaskisnotdone(TaskRepository $taskRepository)
    {
        return $this->render('task/list.html.twig', ['tasks' => $taskRepository->findBy(['isDone' => 0])]);
    }

    /**
     * Create a task.
     *
     * @return RedirectResponse|Response
     */
    public function createTask(Request $request)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $ems = $this->getDoctrine()->getManager();

            $task->setUsers($this->getUser());

            $ems->persist($task);
            $ems->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('todolist_listtask');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * edit task.
     *
     * @param $taskid
     *
     * @return RedirectResponse|Response
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
     * mark task  done.
     *
     * @param $taskid
     *
     * @return RedirectResponse
     */
    public function toggleTask(TaskRepository $taskRepo, $taskid)
    {
        $task = $taskRepo->findOneById($taskid);
        $task->toggle(!$task->isDone());
        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée.', $task->getTitle()));

        return $this->redirectToRoute('todolist_listtask');
    }

    /**
     * Delete Task.
     *
     * @param TaskRepository $taskRepository
     * @param $taskid
     *
     * @return RedirectResponse
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
