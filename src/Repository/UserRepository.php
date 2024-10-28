<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    //    /**
    //     * @return User[] Returns an array of User objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?User
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    
    public function findUsersWithOnlyUnprocessedPDFs()
    {
        return $this->createQueryBuilder('u')
            ->innerJoin('u.documents', 'd')
            ->where('d.isProcessed = false')
            ->groupBy('u.id')
            ->having('COUNT(d.id) = SUM(CASE WHEN d.isProcessed = false THEN 1 ELSE 0 END)')
            ->getQuery()
            ->getResult();
    }
    public function findUsersWithUnprocessedPDFs()
    {
        return $this->createQueryBuilder('u')
            ->innerJoin('u.documents', 'd')
            ->where('d.isProcessed = false')
            ->getQuery()
            ->getResult();
    }
}
