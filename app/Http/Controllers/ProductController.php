<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\APIController;
use App\Services\ProductService;

class ProductController extends APIController
{
    private ProductService $_productService;

    public function __construct(ProductService $service)
    {
        $this->_productService = $service;
    }

    public function index(?string $category=null)
    {
        $products = $this->_productService->retrieveAll($category);
        
        return $products ? response()->json(['request_status' => 'success', 'data' => ['products' => $products]]) : response()->json(['request_status' => 'failure']);
    }

    public function show(string $product_id, ?string $admin=null)
    {
        $product = $this->_productService->retrieve($product_id, $admin);
        
        return $product ? response()->json([
            'request_status' => 'success', 'message' => 'product retrieved successfully', 'data' => ['product' => $product]
            ]) : response()->json(['request_status' => 'failure', 'message' => 'product retrieve failed']);
    }

    public function store(Request $request)
    {
        $data = request()->json()->all();

        $addedProductData = $this->_productService->add($data);

        return $addedProductData ? response()->json([
            'response_status' => 'success', 'message' => 'product added successfully', "data" => ['addedProductData' => $addedProductData]
        ]) : response()->json(['response_status' => 'failure', 'message' => 'product adding failed']);
    }

    public function update(string $product_id, Request $request)
    {
        $data = $request->json()->all();

        $updatedProductData = $this->_productService->update($product_id, $data);
    }

    public function remove(string $product_id, Request $request)
    {

    }
}