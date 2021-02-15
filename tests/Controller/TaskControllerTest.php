<?php

namespace App\Tests\Controller;

use App\Entity\Task;
use App\Entity\User;
use App\Tests\AutTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TaskControllerTest extends WebTestCase
{
    use AutTrait;

    /**
     * List task page test.
     */
    public function testListTask()
    {
        $clt = static::createAuthenticatedUser();
        $entm = $clt->getContainer()->get('doctrine.orm.entity_manager');
        $tasks = $entm->getRepository(Task::class)->findAll();
        $clt->request('GET', '/taskarea/listtask', ['task' => $tasks]);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    /**
     * Restricted access to the task list test.
     */
    public function testListTaskisRestricted()
    {
        $clt = static::createClient();
        $clt->request('GET', '/taskarea/listtask');

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $clt->followRedirect();
        $this->assertRouteSame('security_login');
    }

    /**
     * Restricted access to the create task test.
     */
    public function testCreateTaskisRestricted()
    {
        $clt = static::createClient();
        $clt->request('GET', '/taskarea/createtask');
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $clt->followRedirect();
        $this->assertRouteSame('security_login');
    }

    /**
     * Display create task page if login test.
     */
    public function testDisplayCreateTaskPageifLogin()
    {
        $clt = static::createAuthenticatedUser();

        $clt->request('GET', '/taskarea/createtask');
        $this->assertEquals(
                200,
                $clt->getResponse()->getStatusCode()
            );
    }

    /**
     * Create task test.
     */
    public function testCreateTask()
    {
        $clt = static::createAuthenticatedUser();
        $crawler = $clt->request('GET', '/taskarea/createtask');
        $form = $crawler->selectButton('Ajouter')->form(['task[title]' => 'tasksession3', 'task[content]' => 'task session3']);
        $clt->submit($form);
        $this->assertResponseRedirects();
        $clt->followRedirect();
        $this->assertRouteSame('todolist_listtask');
    }

    /**
     * Edit task test.
     */
    public function testEditTask()
    {
        $clt = static::createAuthenticatedUser();
        $em = $clt->getContainer()->get('doctrine.orm.entity_manager');
        $user = $em->getRepository(User::class)->findOneById(1);
        $task = $em->getRepository(Task::class)->findOneBy(['users' => $user->getId()]);

        $crawler = $clt->request('GET', '/taskarea/edittask/'.$task->getId().'');
        $form = $crawler->selectButton('Modifier')->form(['task[title]' => 'task1ses3', 'task[content]' => 'task testses3']);
        $clt->submit($form);
        $this->assertResponseRedirects();
        $clt->followRedirect();
        $this->assertRouteSame('todolist_listtask');
    }

    /**
     * Restricted access to edit task test.
     */
    public function testEditTaskDenied()
    {
        $clt = static::createAuthenticatedUser();
        $em = $clt->getContainer()->get('doctrine.orm.entity_manager');
        $user = $em->getRepository(User::class)->findOneById(1);
        $task = $em->createQueryBuilder()
             ->select('t')
             ->from(Task::class, 't')
             ->where('t.users != :user')
             ->setParameter('user', $user->getId())
             ->setMaxResults(1)
             ->getQuery()
             ->getSingleResult()
            ;
        $clt->request('GET', '/taskarea/edittask/'.$task->getId().'');
        $this->assertResponseRedirects();
        $clt->followRedirect();
        $this->assertRouteSame('todolist_listtask');
        $this->assertSelectorTextContains('h1', "Desolè vous n'êtes pas autorisé à modifier cette tâche.");
    }

    /**
     * Delete task test.
     */
    public function testDeleteTask()
    {
        $clt = static::createAuthenticatedUser();
        $em = $clt->getContainer()->get('doctrine.orm.entity_manager');
        $user = $em->getRepository(User::class)->findOneById(1);
        $task = $em->getRepository(Task::class)->findOneBy(['users' => $user->getId()]);

        $clt->request('GET', '/taskarea/deletetask/'.$task->getId().'');
        $this->assertResponseRedirects();
        $clt->followRedirect();
        $this->assertRouteSame('todolist_listtask');
    }

    /**
     * Restricted access to delete task  test.
     */
    public function testDeleteTaskDenied()
    {
        $clt = static::createAuthenticatedUser();
        $em = $clt->getContainer()->get('doctrine.orm.entity_manager');
        $user = $em->getRepository(User::class)->findOneById(1);
        $task = $em->createQueryBuilder()
            ->select('t')
            ->from(Task::class, 't')
            ->where('t.users != :user')
            ->setParameter('user', $user->getId())
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult()
        ;
        $clt->request('GET', '/taskarea/deletetask/'.$task->getId().'');
        $this->assertResponseRedirects();
        $clt->followRedirect();
        $this->assertRouteSame('todolist_listtask');
        $this->assertSelectorTextContains('h1', "Desolè vous n'êtes pas autorisé à supprimer cette tâche.");
    }

    /**
     * Toggle task test.
     */
    public function testToggleTask()
    {
        $clt = static::createAuthenticatedUser();
        $em = $clt->getContainer()->get('doctrine.orm.entity_manager');
        $user = $em->getRepository(User::class)->findOneById(1);
        $task = $em->getRepository(Task::class)->findOneBy(['users' => $user->getId(), 'isDone' => 0]);

        $clt->request('GET', '/taskarea/toggletask/'.$task->getId().'');
        $this->assertResponseRedirects();
        $clt->followRedirect();
        $this->assertRouteSame('todolist_listtask');
    }

    /**
     *  Display task is not done test.
     */
    public function testListTaskisnotdone()
    {
        $clt = static::createAuthenticatedUser();

        $em = $clt->getContainer()->get('doctrine.orm.entity_manager');

        $em->getRepository(Task::class)->findOneBy(['isDone' => 0]);

        $clt->request('GET', '/taskarea/listtaskisnotdone');
        $this->assertEquals(
            200,
            $clt->getResponse()->getStatusCode()
        );
    }

    /**
     * Display task is done test.
     */
    public function testListTaskdone()
    {
        $clt = static::createAuthenticatedUser();

        $em = $clt->getContainer()->get('doctrine.orm.entity_manager');

        $em->getRepository(Task::class)->findOneBy(['isDone' => 1]);

        $clt->request('GET', '/taskarea/listtaskdone');
        $this->assertEquals(
            200,
            $clt->getResponse()->getStatusCode()
        );
    }
}
