<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Product;
use App\Factory\CustomerFactory;
use App\Factory\ProductsFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
//        $product1 = new Products();
//        $product1->setName('Monitor');
//        $product1->setCategory('Podzespoły');
//        $product1->setdescription('Monitor 27"');
//        $product1->setPurchasePrice(300);
//        $product1->setSellingPrice(400);
//        $product1->setPurchaseAt(new \DateTimeImmutable());
//        $manager->persist($product1);
//        $manager->flush();


        CustomerFactory::createMany(10);
        ProductsFactory::createMany(20);

    }
}
