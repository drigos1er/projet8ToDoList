<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskTest extends KernelTestCase
{


    public function testAddTask()
    {
        $task = new Task();
        $task->setTitle('task1');
        $task->setUsers(1);
        $task->setContent('MON TASK 1');
        $task->setCreatedAt(new \DateTime());

        self::bootKernel();
        $error = self::$container->get('validator')->validate($task);
        $this->assertCount(0, $error);
    }
}
