<?php

namespace App\Service;

use App\Repository\CategoriesRepository;


Class CategoryService
{
    public function __construct(private CategoriesRepository $categoriesRepository)
    {
        $this->categoriesRepository = $categoriesRepository;
    }

    public function getNameAndIdCategory(): array
    {
        $categories = $this->categoriesRepository->findAll();
        $categoryName = [];
        foreach ($categories as $category)
        {
            $nameCategory = $category->getName();
            $categoryName[$nameCategory] = $category->getId();
        }

        return $categoryName;
    }

}
