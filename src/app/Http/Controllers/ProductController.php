<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        return $this->service->getProducts();
    }
}
