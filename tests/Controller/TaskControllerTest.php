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

    public function testListTask()
    {
        $clt = static::createAuthenticatedUser();
        $em = $clt->getContainer()->get('doctrine.orm.entity_manager');
        $tasks = $em->getRepository(Task::class)->findAll();
        $clt->request('GET', '/taskarea/listtask', ['task' => $tasks]);
        //  $clt->request('GET', $urlGenerator->generate("todolist_listtask",['tasks'=>$tasks]));
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testCreateTaskisRestricted()
    {
        $clt = static::createClient();
        $clt->request('GET', '/taskarea/createtask');
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        $clt->followRedirect();
        $this->assertRouteSame('security_login');
    }

    public function testDisplayCreateTaskPageifLogin()
    {
        $clt = static::createAuthenticatedUser();

        $clt->request('GET', '/taskarea/createtask');
        $this->assertEquals(
                200,
                $clt->getResponse()->getStatusCode()
            );
    }

    public function testCreateTask()
    {
        $clt = static::createAuthenticatedUser();
        $crawler = $clt->request('GET', '/taskarea/createtask');
        $f = $crawler->selectButton('Ajouter')->form(['task[title]' => 'tasksession', 'task[content]' => 'task session']);
        $clt->submit($f);
        $this->assertResponseRedirects();
        $clt->followRedirect();
        $this->assertRouteSame('todolist_listtask');
    }

    public function testEditTask()
    {
        $clt = static::createAuthenticatedUser();
        $em = $clt->getContainer()->get('doctrine.orm.entity_manager');
        $user = $em->getRepository(User::class)->findOneById(1);
        $task = $em->getRepository(Task::class)->findOneBy(['users' => $user->getId()]);

        $crawler = $clt->request('GET', '/taskarea/edittask/'.$task->getId().'');
        $f = $crawler->selectButton('Modifier')->form(['task[title]' => 'task1ses', 'task[content]' => 'task testses']);
        $clt->submit($f);
        $this->assertResponseRedirects();
        $clt->followRedirect();
        $this->assertRouteSame('todolist_listtask');
    }

/*
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
            $this->assertEquals(
                403,
                $clt->getResponse()->getStatusCode()
            );
        }

*/

    public function testDeleteTask()
    {
        $clt = static::createAuthenticatedUser();
        $em = $clt->getContainer()->get('doctrine.orm.entity_manager');
        $user = $em->getRepository(User::class)->findOneById(1);
        $task = $em->getRepository(Task::class)->findOneBy(['users' => $user->getId()]);

        $crawler = $clt->request('GET', '/taskarea/deletetask/'.$task->getId().'');
        $this->assertResponseRedirects();
        $clt->followRedirect();
        $this->assertRouteSame('todolist_listtask');
    }

    public function testToggleTask()
    {
        $clt = static::createAuthenticatedUser();
        $em = $clt->getContainer()->get('doctrine.orm.entity_manager');
        $user = $em->getRepository(User::class)->findOneById(1);
        $task = $em->getRepository(Task::class)->findOneBy(['users' => $user->getId(), 'isDone' => 0]);

        $crawler = $clt->request('GET', '/taskarea/toggletask/'.$task->getId().'');
        $this->assertResponseRedirects();
        $clt->followRedirect();
        $this->assertRouteSame('todolist_listtask');
    }



    public function testListTaskisnotdone()
    {
        $clt = static::createAuthenticatedUser();

        $em = $clt->getContainer()->get('doctrine.orm.entity_manager');

        $task = $em->getRepository(Task::class)->findOneBy(['isDone' => 0]);

        $clt->request('GET', '/taskarea/listtaskisnotdone');
        $this->assertEquals(
            200,
            $clt->getResponse()->getStatusCode()
        );
    }




    public function testListTaskdone()
    {
        $clt = static::createAuthenticatedUser();

        $em = $clt->getContainer()->get('doctrine.orm.entity_manager');

        $task = $em->getRepository(Task::class)->findOneBy(['isDone' => 1]);

        $clt->request('GET', '/taskarea/listtaskdone');
        $this->assertEquals(
            200,
            $clt->getResponse()->getStatusCode()
        );
    }

    /*











        */
}