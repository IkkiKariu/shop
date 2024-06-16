<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\APIController;
use App\Services\ProductService;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\countOf;

class ProductController extends APIController
{
    private ProductService $_service;

    public function __construct(ProductService $service)
    {
        $this->_service = $service;
    }

    public function index(?string $category=null)
    {
        $products = $this->_service->retrieveAll($category);
        
        return $products ? response()->json(['request_status' => 'success', 'data' => ['products' => $products]]) : response()->json(['request_status' => 'failure']);
    }

    public function show(string $product_id)
    {
        $product = $this->_service->retrieve($product_id);
        
        return $product ? response()->json(['request_status' => 'success', 'data' => ['product' => $product]]) : response()->json(['request_status' => 'failure']);
    }

    public function store(Request $request, ?string $photo)
    {
        $data = request()->json()->all();

        $addSuccessfully = $this->_service->add($data);
    }

    public function files(Request $request)
    {
        if(!$request->hasFile('product_photos'))
        {
            return response()->json(
                ['response_status' => 'failure', 'message' => 'Product title photo adding failed']
            );
        }

        $files = $request->file('product_photos');

        var_dump($files);
    }

    public function update(string $product_id, Request $request)
    {

    }

    public function remove(string $product_id, Request $request)
    {

    }

    
}