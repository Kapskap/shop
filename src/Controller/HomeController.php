<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\SortFormType;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function homepage(
        EntityManagerInterface $entityManager,
        Request $request
    ): Response
    {
        $form = $this->createForm(SortFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $query = $form->get('Sortuj:')->getData();

            if ($query=='price-asc'){
                $products = $entityManager->getRepository(Product::class)->findByPriseAsc();
            }
            else if ($query=='price-desc'){
                $products = $entityManager->getRepository(Product::class)->findByPriseDesc();
            }
            else if ($query=='name-asc'){
                $products = $entityManager->getRepository(Product::class)->findByNameAsc();
            }
            else if ($query=='name-desc'){
                $products = $entityManager->getRepository(Product::class)->findByNameDesc();
            }
            else {
                $products = $entityManager->getRepository(Product::class)->findAll();
            }
        }
        else {
            $repository = $entityManager->getRepository(Product::class);
            $products = $repository->findAll();
        }


        return $this->render('main/homepage.html.twig', [
            'products' => $products,
            'form' => $form->createView(),
        ]);
    }
}
