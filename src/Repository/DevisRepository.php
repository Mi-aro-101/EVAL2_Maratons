<?php

namespace App\Repository;

use App\Entity\Devis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;
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


    public function getDevisTotalParMoisParAnnee($annee, EntityManagerInterface $entityManager)  : array
    {
        $result = array();
        $connection = $entityManager->getConnection();
        $sql = "SELECT extract('month' from d.date_devis) as mois, sum(d.prix) as total_devis FROM devis d WHERE extract('year' from d.date_devis) = %s group by extract('month' from d.date_devis)";
        $sql = sprintf($sql, $annee);
        $query = $connection->executeQuery($sql);
        $result = $query->fetchAllAssociative();
        return $result;
    }

    public function findDevisAlongPaiementPourcenage(int $page, int $limit, $today) : PaginationInterface
    {
        return $this->paginator->paginate(
            $this->createQueryBuilder('d')
            ->select('d, (SUM(p.montant)*100)/d.prix as pourcentage_paye')
            ->leftJoin('d.paiements', 'p')
            ->andWhere('d.datefin >= :val')
            ->setParameter('val', $today)
            ->addGroupBy('d.id'),
            $page,
            $limit
        );
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
