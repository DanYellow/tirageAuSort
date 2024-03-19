<?php

namespace App\Repository;

use App\Entity\Award;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Award>
 *
 * @method Award|null find($id, $lockMode = null, $lockVersion = null)
 * @method Award|null findOneBy(array $criteria, array $orderBy = null)
 * @method Award[]    findAll()
 * @method Award[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AwardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Award::class);
    }

    public function getAwardsForYear($date = null)
    {
        if ($date == null) {
            $date = date("Y");
        }

        $query = $this->createQueryBuilder('p')
            ->where('p.year = :year')
            ->setParameter('year', $date)
            ->orderBy('p.title, p.category');

        return $query->getQuery()->getResult();
    }
}
