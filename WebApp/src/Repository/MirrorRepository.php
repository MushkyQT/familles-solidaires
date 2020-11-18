<?php

namespace App\Repository;

use App\Entity\Mirror;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Mirror|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mirror|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mirror[]    findAll()
 * @method Mirror[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MirrorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mirror::class);
    }

    // /**
    //  * @return Mirror[] Returns an array of Mirror objects
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
    public function findOneBySomeField($value): ?Mirror
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
