<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $customer1 = new Customer();
        $customer1->setEmail('test@example.com');
        $customer1->setFirstName('John');
        $customer1->setLastName('Doe');
        $customer1->setPhoneNumber('+480123456789');
        $customer1->setJoinAt(new \DateTimeImmutable('-1 day'));

        $manager->persist($customer1);
        $manager->flush();
    }
}
