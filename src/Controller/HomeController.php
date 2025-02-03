<?php

namespace App\Controller;

use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function homepage(
        customerRepository $customerRepository,
        Request $request,
    ): Response
    {
        $customers = $customerRepository->findAllPage();
        $customers->setMaxPerPage(5);
        $customers->setCurrentPage($request->query->get('page', 1));
//        $customer = $customerRepository->findBy(['id' => 1]);

        return $this->render('main/homepage.html.twig', [
            'customers' => $customers,
//            'customer' => $customer,
        ]);
    }
}
