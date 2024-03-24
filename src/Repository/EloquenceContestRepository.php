<?php

namespace App\Repository;

use App\Entity\EloquenceContest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Common\Collections\ArrayCollection;


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

    public function getParticipantsForYear($date = null)
    {
        if ($date == null) {
            $date = date("Y");
        }

        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT ec, p
            FROM App\Entity\EloquenceContest ec
            INNER JOIN ec.participants p
            WHERE ec.year = :year
            AND p.is_active = 1 
            ORDER BY p.lastname ASC
        ')->setParameter('year', $date);

        $result = $query->getOneOrNullResult();
        if($result == null) {
            return array("participants" => new ArrayCollection([]), "year" => $date);
        }

        return array("participants" => $result->getParticipants(), "year" => $result->getYear());
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
