<?php

namespace App\Repository;

use App\Entity\EloquenceContestParticipant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EloquenceContestParticipant>
 *
 * @method EloquenceContestParticipant|null find($id, $lockMode = null, $lockVersion = null)
 * @method EloquenceContestParticipant|null findOneBy(array $criteria, array $orderBy = null)
 * @method EloquenceContestParticipant[]    findAll()
 * @method EloquenceContestParticipant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EloquenceContestParticipantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EloquenceContestParticipant::class);
    }

    //    /**
    //     * @return EloquenceContestParticipant[] Returns an array of EloquenceContestParticipant objects
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

    //    public function findOneBySomeField($value): ?EloquenceContestParticipant
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
