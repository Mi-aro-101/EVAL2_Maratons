<?php

namespace App\Repository;

use App\Entity\TravauxMaison;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TravauxMaison>
 *
 * @method TravauxMaison|null find($id, $lockMode = null, $lockVersion = null)
 * @method TravauxMaison|null findOneBy(array $criteria, array $orderBy = null)
 * @method TravauxMaison[]    findAll()
 * @method TravauxMaison[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TravauxMaisonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TravauxMaison::class);
    }

    //    /**
    //     * @return TravauxMaison[] Returns an array of TravauxMaison objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?TravauxMaison
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
