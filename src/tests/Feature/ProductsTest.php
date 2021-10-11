<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    /** @test */
    public function it_get_a_full_list_of_products()
    {
        $response = $this->get('/products');

        $response->assertStatus(200);
        $response->assertJsonCount(5);

        $response->assertJsonStructure([
            '*' => [
                'sku',
                'name',
                'category',
                'price' => [
                    'discount_percentage',
                    'original',
                    'final',
                    'currency'
                ]
            ]
        ]);
    }

    /** @test */
    public function it_filters_products_list_by_category()
    {
        $response = $this->get('/products?category=boots');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }
}
