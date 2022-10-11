<?php

namespace App\Repository;

use App\Entity\HotDegree;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HotDegree|null find($id, $lockMode = null, $lockVersion = null)
 * @method HotDegree|null findOneBy(array $criteria, array $orderBy = null)
 * @method HotDegree[]    findAll()
 * @method HotDegree[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HotDegreeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HotDegree::class);
    }

    // /**
    //  * @return HotDegree[] Returns an array of HotDegree objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HotDegree
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
