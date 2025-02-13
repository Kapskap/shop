<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findAllProductPages(): Pagerfanta
    {
        $query = $this->createQueryBuilder('p')
            ->getQuery()
        ;
        return new Pagerfanta(new QueryAdapter($query));
    }

    public function findByPriseAsc(): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.sellingPrice', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
    public function findByPriseDesc(): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.sellingPrice', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByNameAsc(): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.name', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByNameDesc(): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.name', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }
    //    /**
    //     * @return Product[] Returns an array of Product objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Product
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
