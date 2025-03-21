<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\SortAndSearchFormType;

class CategoryController extends AbstractController
{
    #[Route('/category/{category}', name: 'category_get')]
    public function getCategory(
        string $category,
        EntityManagerInterface $entityManager,
        Request $request): Response
    {
        $form = $this->createForm(SortAndSearchFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sort = $form->get('sort')->getData();
            $search = $form->get('search')->getData();
            $category = $form->get('category')->getData();

            $products = $entityManager->getRepository(Product::class)->findAllSearchedAndSort($sort, $search, $category);
        }
        else {
            $products = $entityManager->getRepository(Product::class)->findBy(['category' => $category]);
        }

        if ($category == NULL) {
            throw $this->createNotFoundException('Nie znaleziono kategorii o nazwie: ' . $category);
        }

        return $this->render('main/homepage.html.twig', [
            'products' => $products,
            'form' => $form->createView(),
        ]);
    }
}