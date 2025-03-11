<?php

namespace App\Repository;

use App\Entity\Products;
use App\Entity\Categories;
use App\Model\ProductsStat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Monolog\DateTimeImmutable;


use Doctrine\ORM\Query\ResultSetMapping;

/**
 * @extends ServiceEntityRepository<Products>
 */
class ProductsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Products::class);
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

        $sql = 'SELECT p, c FROM App\Entity\Products p 
                JOIN App\Entity\Categories c
                WHERE (p.name LIKE :search
                OR p.description LIKE :search
                OR p.sellingPrice LIKE :search)
                AND c.id LIKE :category'
            .$orderBy;

        $query = $entityManager->createQuery($sql)->setParameters(
            new ArrayCollection([
                new Parameter('search', $search),
                new Parameter('category', $category)
            ])
        );
dd($query->getResult());
        return $query->getResult();

    }
    
    public function sqlTest(string $category): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT id, name, category_id, description, purchase_price as purchasePrice, selling_price as sellingPrice, purchase_at as purchaseAt 
            FROM products p
            WHERE p.category_id = :category
            ORDER BY p.name ASC
            ';

        $resultSet = $conn->executeQuery($sql, ['category_id' => $category]);
        $array = $resultSet->fetchAllAssociative();

        //przekształcanie danych na tablicę obiektów

        $products = [];

        foreach ($array as $key => $row) {
            $product = new Products();
            $product->setId($row['id']);
            $product->setName($row['name']);
            $product->setCategory($row['category_id']);
            $product->setDescription($row['description']);
            $product->setPurchasePrice($row['purchasePrice']);
            $product->setSellingPrice($row['sellingPrice']);
            $product->setPurchaseAt(DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $row['purchaseAt']));
            $products[] = $product;
        }

//        foreach ($array as $key => $row) {
//                $products[] = new ProductsStat(
//                    $row['id'],
//                    $row['name'],
//                    $row['category'],
//                    $row['description'],
//                    $row['purchasePrice'],
//                    $row['sellingPrice'],
//                    $row['purchaseAt']
//                    );
//        }

        return $products;
    }

}
