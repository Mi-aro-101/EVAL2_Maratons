<?php

namespace App\Repository;

use App\Entity\EtapeCourseMirror;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EtapeCourseMirror>
 *
 * @method EtapeCourseMirror|null find($id, $lockMode = null, $lockVersion = null)
 * @method EtapeCourseMirror|null findOneBy(array $criteria, array $orderBy = null)
 * @method EtapeCourseMirror[]    findAll()
 * @method EtapeCourseMirror[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtapeCourseMirrorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EtapeCourseMirror::class);
    }

    //    /**
    //     * @return EtapeCourseMirror[] Returns an array of EtapeCourseMirror objects
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

    //    public function findOneBySomeField($value): ?EtapeCourseMirror
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
