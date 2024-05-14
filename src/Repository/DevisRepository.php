<?php

namespace App\Repository;

use App\Entity\Devis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Devis>
 *
 * @method Devis|null find($id, $lockMode = null, $lockVersion = null)
 * @method Devis|null findOneBy(array $criteria, array $orderBy = null)
 * @method Devis[]    findAll()
 * @method Devis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DevisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginator)
    {
        parent::__construct($registry, Devis::class);
    }

    public function paginateDevis(int $page, int $limit, $user) : PaginationInterface
    {
        return $this->paginator->paginate(
            $this->createQueryBuilder('r')
            ->andWhere('r.client = :val')
            ->setParameter('val', $user),
            $page,
            $limit
        );
    }

    //    /**
    //     * @return Devis[] Returns an array of Devis objects
    //     */
       public function findDevisEnCours(int $page, int $limit, $today) /** PaginationInterface */
       {
          return $this->paginator->paginate(
              $this->createQueryBuilder('d')
                  ->andWhere('d.datefin >= :val')
                  ->setParameter('val', $today),
                  $page,
                  $limit
              )
              ;
       }

    //    public function findOneBySomeField($value): ?Devis
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
