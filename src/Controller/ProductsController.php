<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\SortAndSearchFormType;

class ProductsController extends AbstractController
{
    #[Route('/products/', name: 'products_show')]
    public function products(
        EntityManagerInterface $entityManager,
        Request $request
    ): Response
    {
        $category = $entityManager->getRepository(Category::class)->findMain();

        $form = $this->createForm(SortAndSearchFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sort = $form->get('sort')->getData();
            $search = $form->get('search')->getData();
            $products = $entityManager->getRepository(Product::class)->findAllSearchedAndSort($sort, $search, NULL);
        }
        else {
            $repository = $entityManager->getRepository(Product::class);
            $products = $repository->findAll();
        }

        return $this->render('products/products.html.twig', [
            'products' => $products,
            'categories' => $category,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/products/{parent}', name: 'products_category')]
    public function productsCategory(
        string $parent,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response
    {
        $previous = $entityManager->getRepository(Category::class)->findParent($parent);
        $category = $entityManager->getRepository(Category::class)->findChild($parent);
        $subcategory = $entityManager->getRepository(Category::class)->findSubcategoriesId($parent);

        $form = $this->createForm(SortAndSearchFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sort = $form->get('sort')->getData();
            $search = $form->get('search')->getData();
//            $formCategory = $form->get('category')->getData();

            $products = $entityManager->getRepository(Product::class)->findAllSearchedAndSort($sort, $search, $subcategory);
//            $products2 = $entityManager->getRepository(Product::class)->findDQL($sort, $search, $category);
//            $products3 = $entityManager->getRepository(Product::class)->findQueryDQL($sort, $search, $category);
//
//            dd($products, $products2, $products3);
        }
        else {
            $products = $entityManager->getRepository(Product::class)->findAllSearchedAndSort(NULL, NULL, $subcategory);
        }

        return $this->render('products/products.html.twig', [
            'products' => $products,
            'previous' => $previous,
            'categories' => $category,
            'form' => $form->createView(),
        ]);
    }
}
