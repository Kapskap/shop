<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function homepage(
        EntityManagerInterface $entityManager,
    ): Response
    {
        $repository = $entityManager->getRepository(Product::class);
        $products = $repository->findAll();


        return $this->render('main/homepage.html.twig', [
            'products' => $products,
        ]);
    }
}
