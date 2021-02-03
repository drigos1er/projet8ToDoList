<?php

namespace App\Tests\Repository;

use App\Repository\TodoRoleRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TodoRoleRepositoryTest extends KernelTestCase
{
    public function testCountTodoRole()
    {
        self::bootKernel();
        $todoroles = self::$container->get(TodoRoleRepository::class)->count([]);
        $this->assertEquals(2, $todoroles);
    }
}
