<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Category>
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function findMain(): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.id = c.parent')
            ->orderBy('c.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findParent($parent): Category
    {
        $parent = $this->createQueryBuilder('c')
            ->andWhere('c.id = :parent')
            ->setParameter('parent', $parent)
            ->getQuery()
            ->getResult();
        return $parent[0];
    }

    public function findChild($parent = NULL): array
    {
        $entityManager = $this->getEntityManager();

        $sql = 'SELECT c FROM App\Entity\Category c 
                WHERE c.parent = :parent
                AND c.id != :parent
                ORDER BY c.name ASC';

        $query = $entityManager->createQuery($sql)
            ->setParameter('parent', $parent)
            ;

        return $query->getResult();
    }

    public function findSubcategoriesId($parent): array
    {
        $result = [];
        $result[] = (int)$parent;
        $level = 0;

        $entityManager = $this->getEntityManager();

        $sql = 'SELECT c.id FROM App\Entity\Category c 
                WHERE c.parent = :parent
                AND c.id != :parent
                ORDER BY c.id ASC';

        $query = $entityManager->createQuery($sql)
            ->setParameter('parent', $result[$level]);

        while( $level < count($result) ) {
            $i = 0;
            $query = $entityManager->createQuery($sql)
                ->setParameter('parent', $result[$level]);

            while ( isset($query->getResult()[$i]['id']) ) {
                    $result[] = $query->getResult()[$i]['id'];
                    $i++;
            }
            $level++;
        }

        return $result;
    }

    //    /**
    //     * @return Categories[] Returns an array of Categories objects
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

}
