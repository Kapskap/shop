<?php

namespace App\Controller;

use App\Repository\CustomerRepository;
use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CustomerController extends AbstractController
{
    #[Route('/customers', name: 'customers_show')]
    public function showCustomers(
        customerRepository $customerRepository,
        Request $request,
    ): Response
    {
        $customers = $customerRepository->findAllPage();
        $customers->setMaxPerPage(5);
        $customers->setCurrentPage($request->query->get('page', 1));


        return $this->render('main/homepage.html.twig', [
            'customers' => $customers,
        ]);
    }

    #[Route('/customer/{id<\d+>}', name: 'customer_get')]
    public function getCustomer($id, EntityManagerInterface $entityManager): Response
    {
        $customer = $entityManager->getRepository(Customer::class)->find($id);
        if (!$customer) {
            throw $this->createNotFoundException('Nie znaleziono id '.$id);
        }

        return $this->render('customers/getCustomer.html.twig', [
            'customer'=>$customer,
            ]);
    }

}