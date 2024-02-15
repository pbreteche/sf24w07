<?php

namespace App\Repository;

use App\Entity\TShirt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TShirt>
 *
 * @method TShirt|null find($id, $lockMode = null, $lockVersion = null)
 * @method TShirt|null findOneBy(array $criteria, array $orderBy = null)
 * @method TShirt[]    findAll()
 * @method TShirt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TShirtRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TShirt::class);
    }

    public function stat(string $metric, bool $bySize)
    {
        $queryBuilder = $this->createQueryBuilder('tshirt');

        switch ($metric) {
            case 'quantity':
                $queryBuilder->select('COUNT(tshirt) AS data');
                break;
            case 'avg':
                $queryBuilder->select('AVG(tshirt.price) AS data');
                break;
            default:
                $queryBuilder->select('SUM(tshirt.price) AS data');
        }

        if ($bySize) {
            $queryBuilder
                ->groupBy('tshirt.size')
                ->addSelect('tshirt.size')
            ;
        }

        return $queryBuilder
            ->getQuery()
            ->getResult()
        ;
    }
}
