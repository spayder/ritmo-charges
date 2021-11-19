<?php

namespace App\Http\Controllers;

use App\Services\ChargesService;

class ChargesController extends Controller
{
    /**
     * @var ChargesController
     */
    private $service;

    public function __construct(ChargesService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $this->service->handle();

        dd('Finished');
    }
}
