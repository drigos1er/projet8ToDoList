<?php

namespace App\DataFixtures;
use App\Entity\ToDoRole;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class AppFixtures extends Fixture
{
     public function load(ObjectManager $manager)
    {



        $user= new User();


        $user->setUsername('todoadm');

        $user->setPassword('$2y$13$g2D326TAtfVUj5uEwzHyROF5bn63IxOn5c67CkiDFJznV7D4s5DcK');
        $user->setEmail('todoadm@todo.ci');
        $user->setUserrole(1);



        $todorole1= new ToDoRole();
        $todorole2= new ToDoRole();
      ;


        $todorole1->setTitle('ROLE_ADMIN');


        $todorole2->setTitle('ROLE_USER');


        $todorole1->adduser($user);

        $manager->persist($user);

        $manager->persist($todorole1);
        $manager->persist($todorole2);

        $manager->flush();
    }
}
