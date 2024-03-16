<?php

namespace App\Repository;

use App\Entity\EloquenceContest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EloquenceContest>
 *
 * @method EloquenceContest|null find($id, $lockMode = null, $lockVersion = null)
 * @method EloquenceContest|null findOneBy(array $criteria, array $orderBy = null)
 * @method EloquenceContest[]    findAll()
 * @method EloquenceContest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EloquenceContestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EloquenceContest::class);
    }

    //    /**
    //     * @return EloquenceContest[] Returns an array of EloquenceContest objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?EloquenceContest
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
