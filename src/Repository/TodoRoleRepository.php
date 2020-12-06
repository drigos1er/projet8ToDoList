<?php

namespace App\Repository;

use App\Entity\Task;

use App\Entity\ToDoRole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TodoRole|null find($id, $lockMode = null, $lockVersion = null)
 * @method TodoRole|null findOneBy(array $criteria, array $orderBy = null)
 * @method ToDoRole[]    findAll()
 * @method TodoRole[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TodoRoleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    // /**
    //  * @return Grade[] Returns an array of Grade objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Grade
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
