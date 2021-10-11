<?php

namespace App\Services;

use Facades\App\Models\Discount;
use Facades\App\Models\Product;

class ProductService
{
    public function getProducts()
    {
        return Discount::applyFor(
            Product::getProducts()
        );

    }
}
