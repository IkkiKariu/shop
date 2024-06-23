<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PriceService;

class PriceController extends Controller
{
    private PriceService $_priceService;

    public function __construct(PriceService $priceService)
    {
        $this->_priceService = $priceService;
    }

    public function index(string $productId)
    {
        
    }

    public function show(string $id)
    {

    }

    public function add(string $productId)
    {

    }

    public function update(string $id)
    {

    }

    public function remove(string $id)
    {

    }
}
