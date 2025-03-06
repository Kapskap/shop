<?php

namespace App\Controller;

use App\Repository\ProductsRepository;
use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{

    #[Route('/product/{id<\d+>}', name: 'product_get')]
    public function getProduct($id, EntityManagerInterface $entityManager): Response
    {
        $product = $entityManager->getRepository(Products::class)->find($id);
        if (!$product) {
            throw $this->createNotFoundException('Nie znaleziono produktu o id '.$id);
        }

        return $this->render('products/getProduct.html.twig', [
            'product'=>$product,
        ]);
    }

}