<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Repository\TaskRepository;
use App\Repository\TodoRoleRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskTest extends KernelTestCase
{


    public function testAddTask()
    {

        $task = new Task();
        $task->setTitle('task10');
        $task->setUsers(1);
        $task->setContent('MON TASK 10');
        $task->setCreatedAt(new \DateTime());
        self::bootKernel();
        $error = self::$container->get('validator')->validate($task);
        $this->assertCount(0, $error);
    }
}
