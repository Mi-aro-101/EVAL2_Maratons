<?php

namespace App\Repository;

use App\Entity\DevisDetails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DevisDetails>
 *
 * @method DevisDetails|null find($id, $lockMode = null, $lockVersion = null)
 * @method DevisDetails|null findOneBy(array $criteria, array $orderBy = null)
 * @method DevisDetails[]    findAll()
 * @method DevisDetails[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DevisDetailsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DevisDetails::class);
    }

    //    /**
    //     * @return DevisDetails[] Returns an array of DevisDetails objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?DevisDetails
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
