<?php

namespace App\Service;

use App\Repository\ProductRepository;
use App\Entity\Product;

Class ProductService
{
    public function __construct(private ProductRepository $productRepository)
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
