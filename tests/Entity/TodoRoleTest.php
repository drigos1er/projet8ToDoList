<?php

namespace App\Tests\Entity;

use App\Entity\ToDoRole;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TodoRoleTest extends KernelTestCase
{
    /**
     * Validation adding todorole test.
     */
    public function testAddTodoRole()
    {
        $todorole = new ToDoRole();
        $todorole->setTitle('ANONYME');
        self::bootKernel();
        $error = self::$container->get('validator')->validate($todorole);
        $this->assertCount(0, $error);
    }
}
