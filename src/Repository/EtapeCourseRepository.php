<?php

namespace App\Repository;

use App\Entity\EtapeCourse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<EtapeCourse>
 *
 * @method EtapeCourse|null find($id, $lockMode = null, $lockVersion = null)
 * @method EtapeCourse|null findOneBy(array $criteria, array $orderBy = null)
 * @method EtapeCourse[]    findAll()
 * @method EtapeCourse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtapeCourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginator)
    {
        parent::__construct($registry, EtapeCourse::class);
    }

    public function paginateEtapeCourse(int $page, int $limit) : PaginationInterface
    {
        return $this->paginator->paginate(
            $this->createQueryBuilder('e'),
            $page,
            $limit
        );
    }

    public function paginateEtapeCourseByCourse($page, $limit, $course) : PaginationInterface
    {
        return $this->paginator->paginate(
            $this->createQueryBuilder('e')
            ->andWhere('e.course = :val')
            ->setParameter('val', $course),
            $page,
            $limit
        );
    }

    //    /**
    //     * @return EtapeCourse[] Returns an array of EtapeCourse objects
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

    //    public function findOneBySomeField($value): ?EtapeCourse
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
