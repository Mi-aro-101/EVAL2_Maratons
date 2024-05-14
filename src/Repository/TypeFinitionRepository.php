<?php

namespace App\Repository;

use App\Entity\TypeFinition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypeFinition>
 *
 * @method TypeFinition|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeFinition|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeFinition[]    findAll()
 * @method TypeFinition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeFinitionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeFinition::class);
    }

    //    /**
    //     * @return TypeFinition[] Returns an array of TypeFinition objects
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

    //    public function findOneBySomeField($value): ?TypeFinition
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
