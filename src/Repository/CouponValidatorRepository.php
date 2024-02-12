<?php

namespace App\Repository;

use App\Service\CouponValidator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CouponValidator>
 *
 * @method CouponValidator|null find($id, $lockMode = null, $lockVersion = null)
 * @method CouponValidator|null findOneBy(array $criteria, array $orderBy = null)
 * @method CouponValidator[]    findAll()
 * @method CouponValidator[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CouponValidatorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CouponValidator::class);
    }

//    /**
//     * @return CouponValidator[] Returns an array of CouponValidator objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CouponValidator
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
