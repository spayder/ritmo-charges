<?php

namespace Tests\Unit;

use Facades\App\Models\Discount;
use PHPUnit\Framework\TestCase;

class ProductDiscountTest extends TestCase
{
    /** @test */
    public function it_applies_discount_for_a_product_by_category()
    {
        $products = collect([[
            'sku' => '000001',
            'name' => 'BV Lean leather ankle boots',
            'category' => 'boots',
            'price' => 89000,
        ],
        [
            "sku" => "000005",
            "name" => "Nathane leather sneakers",
            "category" => "sneakers",
            "price" => 59000,
        ]]);

        $discountModel = app(\App\Models\Discount::class);
        $productsWithDiscount = $discountModel->applyFor($products);

        $this->assertEquals($productsWithDiscount[0]['price']['discount_percentage'], 30);
        $this->assertNull($productsWithDiscount[1]['price']['discount_percentage']);
    }
}
