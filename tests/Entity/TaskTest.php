<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskTest extends KernelTestCase
{
    /**
     * Validation adding task test
     */
    public function testAddTask()
    {
        $task = new Task();
        $task->setTitle('task11');
        $task->setUsers(1);
        $task->setContent('MON TASK 11');
        $task->setCreatedAt(new \DateTime());
        self::bootKernel();
        $error = self::$container->get('validator')->validate($task);
        $this->assertCount(0, $error);
    }
}
