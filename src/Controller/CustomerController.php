<?php

namespace App\Controller;

use App\Repository\CustomerRepository;
use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation;

class CustomerController extends AbstractController
{
    #[Route('/customer/{id<\d+>}', name: 'show_customer')]
    public function getCustomer($id, EntityManagerInterface $entityManager): Response
    {
        $customer = $entityManager->getRepository(Customer::class)->find($id);
        if (!$customer) {
            throw $this->createNotFoundException('Nie znaleziono id '.$id);
        }

        return $this->render('customer/show.html.twig', [
            'customer'=>$customer,
            ]);
    }

}