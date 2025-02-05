<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Product;
use App\Factory\CustomerFactory;
use App\Factory\ProductFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
//        $product1 = new Product();
//        $product1->setName('Monitor');
//        $product1->setCategory('Podzespoły');
//        $product1->setdescription('Monitor 27"');
//        $product1->setPuscharePrice(300);
//        $product1->setSellingPrice(400);
//        $product1->setPuschareAt(new \DateTimeImmutable());
//        $manager->persist($product1);
//        $manager->flush();


        CustomerFactory::createMany(10);
        ProductFactory::createMany(20);

    }
}
