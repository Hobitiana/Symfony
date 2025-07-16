<?php

namespace App\Repository;

use App\Entity\DesignationReference;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DesignationReference>
 */
class DesignationReferenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DesignationReference::class);
    }

//    /**
//     * @return DesignationReference[] Returns an array of DesignationReference objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DesignationReference
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
public function findReferenceByUser($user): ?DesignationReference
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
