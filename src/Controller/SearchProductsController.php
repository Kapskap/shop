<?php

namespace App\Controller;

use App\Entity\Products;
use App\Form\SortAndSearchFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SearchProductsController extends AbstractController
{
    public function SortAndSearch(
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
            $products2 = $entityManager->getRepository(Products::class)->nativeTest($category);
            $products3 = $entityManager->getRepository(Products::class)->sqlTest($category);
            dd($products, $products2, $products3);
        }
        else {
            $repository = $entityManager->getRepository(Products::class);
            $products = $repository->findAll();
        }

        return $this->render('form/_SortAndSearch.html.twig', [
            'products' => $products,
            'form' => $form->createView(),
        ]);
    }
}