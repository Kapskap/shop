<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function homepage(
        productRepository $productRepository,
        Request $request,
    ): Response
    {
        $products = $productRepository->findAllProductPages();
        $products->setMaxPerPage(5);
        $products->setCurrentPage($request->query->get('page', 1));


        return $this->render('main/homepage.html.twig', [
            'products' => $products,
        ]);
    }
}
