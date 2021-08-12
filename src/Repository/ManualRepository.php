<?php

namespace App\Repository;

use App\Entity\Manual;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Manual|null find($id, $lockMode = null, $lockVersion = null)
 * @method Manual|null findOneBy(array $criteria, array $orderBy = null)
 * @method Manual[]    findAll()
 * @method Manual[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ManualRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Manual::class);
    }

    // /**
    //  * @return Manual[] Returns an array of Manual objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Manual
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
