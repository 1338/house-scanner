<?php

namespace App\Repository;

use App\Entity\Neighbourhood;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Neighbourhood>
 *
 * @method Neighbourhood|null find($id, $lockMode = null, $lockVersion = null)
 * @method Neighbourhood|null findOneBy(array $criteria, array $orderBy = null)
 * @method Neighbourhood[]    findAll()
 * @method Neighbourhood[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NeighbourhoodRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Neighbourhood::class);
    }

    public function add(Neighbourhood $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Neighbourhood $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Neighbourhood[] Returns an array of Neighbourhood objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Neighbourhood
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
