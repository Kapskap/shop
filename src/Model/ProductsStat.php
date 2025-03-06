<?php

namespace App\Model;

class ProductsStat
{
    public function __construct(
        public int $id,
        public string $name,
        public string $category,
        public string $description,
        public int $purchasePrice,
        public int $sellingPrice,
        public string $purchaseAt
    )
    {
    }
}