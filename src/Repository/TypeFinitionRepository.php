<?php

namespace App\Repository;

use App\Entity\TypeFinition;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

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
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginator)
    {
        parent::__construct($registry, TypeFinition::class);
    }

    public function paginateTypeFinition(int $page, int $limit) : PaginationInterface
    {
        return $this->paginator->paginate(
            $this->createQueryBuilder('r'),
            $page,
            $limit
        );
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
