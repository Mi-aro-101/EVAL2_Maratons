<?php

namespace App\Repository;

use App\Entity\ClassementCategorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ClassementCategorie>
 *
 * @method ClassementCategorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClassementCategorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClassementCategorie[]    findAll()
 * @method ClassementCategorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClassementCategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClassementCategorie::class);
    }

    //    /**
    //     * @return ClassementCategorie[] Returns an array of ClassementCategorie objects
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

    //    public function findOneBySomeField($value): ?ClassementCategorie
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
