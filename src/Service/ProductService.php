<?php

namespace App\Service;

use App\Repository\ProductsRepository;
use App\Entity\Products;

Class ProductService
{
    public function __construct(private ProductsRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getProductCategory(): array
    {
        $products = $this->productRepository->findAll();
        foreach ($products as $product)
        {
            $productCategory = $product->getCategory();
            $category[$productCategory] = $productCategory;
        }
        return $category;
    }

}
