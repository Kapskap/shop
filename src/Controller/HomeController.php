<?php

namespace App\Controller;

use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\SortAndSearchFormType;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function homepage(
        EntityManagerInterface $entityManager,
        Request $request
    ): Response
    {
        $news = array("wpis1"=>"Promocja", "wpis2"=>"Nowy produkt");


        return $this->render('main/homepage.html.twig', [
            'news' => $news,
        ]);
    }
}
