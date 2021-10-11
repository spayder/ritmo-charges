<?php

namespace App\Models;

use App\Presenters\Money;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Discount extends Model
{
    private function currentDiscounts()
    {
        return [
            'category' => [
                'boots' => 30
            ],
            'sku' => [
                '000003' => 15
            ]
        ];
    }

    public function applyFor(collection $products)
    {
        return $products->map(function($product) {
            $discount = $this->getDiscountFor($product);
            $original = $product['price'];
            $product['price'] = [
                'discount_percentage' => $discount,
                'original' => $original,
                'final' => Money::calculatePriceWithDiscount($original, $discount),
                'currency' => Money::CURRENCY
            ];
            return $product;
        });
    }

    private function getDiscountFor(array $product)
    {
        $discounts = [];
        foreach ($this->currentDiscounts() as $type => $discount) {
            if (isset($discount[$product[$type]])) {
                $discounts[] = $discount[$product[$type]];
            }
        }

        return empty($discounts) ? null : max($discounts);
    }
}
