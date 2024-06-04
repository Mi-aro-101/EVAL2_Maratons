<?php

namespace App\Repository;

use App\Entity\PointRang;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PointRang>
 *
 * @method PointRang|null find($id, $lockMode = null, $lockVersion = null)
 * @method PointRang|null findOneBy(array $criteria, array $orderBy = null)
 * @method PointRang[]    findAll()
 * @method PointRang[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PointRangRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PointRang::class);
    }

    //    /**
    //     * @return PointRang[] Returns an array of PointRang objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?PointRang
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
