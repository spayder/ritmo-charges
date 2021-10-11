<?php

namespace App\Models;

use App\Presenters\Money;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Product extends Model
{
    /**
     * @var \Illuminate\Support\Collection
     */
    private $products;

    protected $perPage = 5;

    private function getAll(): Product
    {
        $cache_key = 'all_products';
        if (Cache::has($cache_key)) {
            $this->products = Cache::get($cache_key);
            return $this;
        }

        $file = file_get_contents(database_path('data.json'));
        $this->products =  collect(json_decode($file, true)['products']);

        Cache::forever($cache_key, $this->products);

        return $this;
    }

    private function applyFilters(): \Illuminate\Support\Collection
    {
        if (request()->has('category')) {
            $this->products = $this->products->where('category', request()->category);
        }

        if (request()->has('priceLessThan')) {
            $this->products = $this->products->where('price', '<', Money::toCents(request()->priceLessThan));
        }

        return $this->products;
    }

    public function getProducts(): \Illuminate\Support\Collection
    {
        $products = $this->getAll()
            ->applyFilters()
            ->chunk($this->perPage);

        if (! request()->has('page')) {
            $page = 1;
        } else {
            $page = request()->page;
        }

        return $products[$page - 1]->values();
    }

    public function perPage()
    {
        return $this->perPage();
    }
}
