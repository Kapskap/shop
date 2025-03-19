<?php

namespace App\Repository;

use App\Entity\Products;
use App\Entity\Categories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Monolog\DateTimeImmutable;

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

    /**
     * @return Products[]
     */
    public  function findDQL($sort, $search, $category): array
    {
        return $this->createQueryBuilder('products')
            ->leftJoin('products.category', 'categories')
            ->andWhere('products.name LIKE :search OR products.description LIKE :search OR products.sellingPrice LIKE :search')
            ->andWhere('categories.id LIKE :category')
            ->setParameter('search', '%'.$search.'%')
            ->setParameter('category', $category)
            ->getQuery()
            ->getResult();
    }

    public function findAllSearchedAndSortDQL($sort, $search, $category): array
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
        return $query->getResult();

    }
    
    public function findAllSearchedAndSort($sort, $search, $category): array
    {
        if ($sort != NULL){
            $sort = explode('-',$sort);
            $orderBy = " ORDER BY p.$sort[0] $sort[1]";
        }
        else{
            $orderBy = "";
        }

        if ($search != NULL){
            $search = "%".$search."%";
        }
        else {
            $search = "%";
        }

        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT p.id, p.name as name, category_id, description, purchase_price as purchasePrice, 
                   selling_price as sellingPrice, purchase_at as purchaseAt, c.name as category, c.parent_id 
            FROM products p JOIN categories c
            ON p.category_id = c.id
            WHERE p.category_id LIKE :category
            AND (p.name LIKE :search
                OR p.description LIKE :search
                OR p.selling_price LIKE :search)
            '.$orderBy;

        $resultSet = $conn->executeQuery($sql, ['category' => $category, 'search' => $search]);
        $array = $resultSet->fetchAllAssociative();

        //przekształcanie danych na tablicę obiektów

        $products = [];

        foreach ($array as $key => $row) {
            $category = new Categories();
            $category->setId($row['category_id']);
            $category->setName($row['category']);
            $category->setParentId($row['parent_id']);

            $product = new Products();
            $product->setId($row['id']);
            $product->setName($row['name']);
            $product->setCategory($category);
            $product->setDescription($row['description']);
            $product->setPurchasePrice($row['purchasePrice']);
            $product->setSellingPrice($row['sellingPrice']);
            $product->setPurchaseAt(DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $row['purchaseAt']));
            $products[] = $product;
        }

        return $products;
    }

}
