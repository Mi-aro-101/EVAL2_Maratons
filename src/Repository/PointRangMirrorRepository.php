<?php

namespace App\Repository;

use App\Entity\PointRangMirror;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PointRangMirror>
 *
 * @method PointRangMirror|null find($id, $lockMode = null, $lockVersion = null)
 * @method PointRangMirror|null findOneBy(array $criteria, array $orderBy = null)
 * @method PointRangMirror[]    findAll()
 * @method PointRangMirror[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PointRangMirrorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PointRangMirror::class);
    }

    //    /**
    //     * @return PointRangMirror[] Returns an array of PointRangMirror objects
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

    //    public function findOneBySomeField($value): ?PointRangMirror
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
