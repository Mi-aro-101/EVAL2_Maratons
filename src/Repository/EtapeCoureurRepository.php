<?php

namespace App\Repository;

use App\Entity\EtapeCoureur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EtapeCoureur>
 *
 * @method EtapeCoureur|null find($id, $lockMode = null, $lockVersion = null)
 * @method EtapeCoureur|null findOneBy(array $criteria, array $orderBy = null)
 * @method EtapeCoureur[]    findAll()
 * @method EtapeCoureur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtapeCoureurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EtapeCoureur::class);
    }

    /**
     * Find all those coureur if they are already assigned to this etape
     * @return EtapeCoureur[]
     */
    public function findCoureurIfCoureurDejaAssignee($coureurs, $etapeCourse) : array
    {
        $queryBuilder = $this->createQueryBuilder('c');
        // dd($queryBuilder
        //     ->select('c')
        //     ->andWhere($queryBuilder->expr()->in('c.coureur', $coureurs))
        //     ->andWhere('c.etapeCourse = :val')
        //     ->setParameter('val', $etapeCourse)
        //     ->getQuery()
        // );
        return $queryBuilder
        ->select('c')
        ->andWhere($queryBuilder->expr()->in('c.coureur', $coureurs))
        ->andWhere('c.etapeCourse = :val')
        ->setParameter('val', $etapeCourse)
        ->getQuery()
        ->getResult();
    }

    public function findCoureurByEquipeAndEtape($equipe, $etape) : array
    {
        // dd($this->createQueryBuilder('ec')
        //     ->innerJoin('ec.coureur', 'c')
        //     ->andWhere('ec.etapeCourse = :val')
        //     ->setParameter('val', $etape)
        //     ->andWhere('c.equipe = :val2')
        //     ->setParameter('val2', $equipe)
        //     ->getQuery()
        //     // ->getResult()
        // );
        return $this->createQueryBuilder('ec')
        ->innerJoin('ec.coureur', 'c')
        ->andWhere('ec.etapeCourse = :val')
        ->setParameter('val', $etape)
        ->andWhere('c.equipe = :val2')
        ->setParameter('val2', $equipe)
        ->getQuery()
        ->getResult()
        ;
    }

    //    /**
    //     * @return EtapeCoureur[] Returns an array of EtapeCoureur objects
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

    //    public function findOneBySomeField($value): ?EtapeCoureur
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
