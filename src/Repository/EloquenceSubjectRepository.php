<?php

namespace App\Repository;

use App\Entity\EloquenceSubject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EloquenceSubject>
 *
 * @method EloquenceSubject|null find($id, $lockMode = null, $lockVersion = null)
 * @method EloquenceSubject|null findOneBy(array $criteria, array $orderBy = null)
 * @method EloquenceSubject[]    findAll()
 * @method EloquenceSubject[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EloquenceSubjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EloquenceSubject::class);
    }

    //    /**
    //     * @return EloquenceSubject[] Returns an array of EloquenceSubject objects
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

    //    public function findOneBySomeField($value): ?EloquenceSubject
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
