<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;

use Doctrine\ORM\Query\ResultSetMapping;

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

    public function findBySearchField($search): array
    {
            return $this->createQueryBuilder('p')
                ->andWhere('p.name = :name')
                ->setParameter('name', $search)
                ->orderBy('p.sellingPrice', 'ASC')
                ->getQuery()
                ->getResult()
            ;
    }

    public function findAllSearchedAndSort($sort, $search, $category): array
    {
        $entityManager = $this->getEntityManager();

        if ($sort != NULL){
            $sort = explode('-',$sort);
            $orderBy = " ORDER BY p.$sort[0] $sort[1]";
        }
        else{
            $orderBy = "";
        }

        if ($search != NULL){
            $search="%".$search."%";
        }
        else {
            $search = "%";
        }

        $sql = 'SELECT p FROM App\Entity\Product p 
                WHERE (p.name LIKE :search
                OR p.description LIKE :search
                OR p.sellingPrice LIKE :search)
                AND p.category LIKE :category'
            .$orderBy;

        $query = $entityManager->createQuery($sql)->setParameters(
            new ArrayCollection([
                new Parameter('search', $search),
                new Parameter('category', $category)
            ])
        );

        return $query->getResult();

    }

    //nativeQuery
    public function nativeTest($category): array
    {
        $em = $this->getEntityManager();
        $rsm = new ResultSetMapping();
        $query = $em->createNativeQuery('SELECT * FROM product p WHERE category = ? ORDER BY p.selling_price ASC', $rsm);

        $query->setParameter(1, 'Drukarka');
        //mapowanie
        return $query->getResult();

    }

    public function sqlTest(string $category): Product
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT id, name, category, description, puschare_price as puscharePrice, selling_price as sellingPrice, puschare_at as puschareAt 
            FROM product p
            WHERE p.category = :category
            ORDER BY p.name ASC
            limit 1';

        $resultSet = $conn->executeQuery($sql, ['category' => $category]);

        return new Product(...$resultSet->fetchAllAssociative());
    }


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
