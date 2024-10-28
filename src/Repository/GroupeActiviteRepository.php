<?php

namespace App\Repository;

use App\Entity\GroupeActivite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GroupeActivite>
 */
class GroupeActiviteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GroupeActivite::class);
    }

    //    /**
    //     * @return GroupeActivite[] Returns an array of GroupeActivite objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('g.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?GroupeActivite
    //    {
    //        return $this->createQueryBuilder('g')
    //            ->andWhere('g.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function findGroupeActiviteByUser($user): ?GroupeActivite
{
    return $this->createQueryBuilder('g')
        ->andWhere('g.user = :user')
        ->setParameter('user', $user)
        ->orderBy('g.id', 'DESC') // Assuming you want the most recent one
        ->setMaxResults(1) // Only return one result
        ->getQuery()
        ->getOneOrNullResult();
}
}
