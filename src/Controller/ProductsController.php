<?php

namespace App\Controller;

use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\SortAndSearchFormType;

class ProductsController extends AbstractController
{
    #[Route('/products', name: 'products_show')]
    public function products(
        EntityManagerInterface $entityManager,
        Request $request
    ): Response
    {
        $form = $this->createForm(SortAndSearchFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sort = $form->get('sort')->getData();
            $search = $form->get('search')->getData();
            $category = $form->get('category')->getData();

            $products = $entityManager->getRepository(Products::class)->findAllSearchedAndSort($sort, $search, $category);
//            $products2 = $entityManager->getRepository(Products::class)->findDQL($sort, $search, $category);
//            $products3 = $entityManager->getRepository(Products::class)->findQueryDQL($sort, $search, $category);
//
//            dd($products, $products2, $products3);
        }
        else {
            $repository = $entityManager->getRepository(Products::class);
            $products = $repository->findAll();
        }

        return $this->render('products/products.html.twig', [
            'products' => $products,
            'form' => $form->createView(),
        ]);
    }
}
