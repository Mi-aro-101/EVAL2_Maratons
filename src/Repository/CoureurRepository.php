<?php

namespace App\Repository;

use App\Entity\Coureur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Coureur>
 *
 * @method Coureur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Coureur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Coureur[]    findAll()
 * @method Coureur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoureurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Coureur::class);
    }

    public function findWhereIn($ids) : array
    {
        $queryBuilder = $this->createQueryBuilder('c');
        return $queryBuilder
        ->select('c')
        ->andWhere($queryBuilder->expr()->in('c.id', $ids))
        ->getQuery()
        ->getResult();
    }

    //    /**
    //     * @return Coureur[] Returns an array of Coureur objects
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

    //    public function findOneBySomeField($value): ?Coureur
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
