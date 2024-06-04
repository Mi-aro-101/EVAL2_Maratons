<?php

namespace App\Repository;

use App\Entity\CategorieCoureur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CategorieCoureur>
 *
 * @method CategorieCoureur|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorieCoureur|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorieCoureur[]    findAll()
 * @method CategorieCoureur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieCoureurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategorieCoureur::class);
    }

    //    /**
    //     * @return CategorieCoureur[] Returns an array of CategorieCoureur objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?CategorieCoureur
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
