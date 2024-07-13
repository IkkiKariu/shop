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
        
        return $products ? response()->json([
            'response_status' => 'success', 'message' => 'products retrieved successfully', 'data' => ['products' => $products]
        ]) : response()->json(['request_status' => 'failure', 'message' => 'products retrieve failed']);
    }

    public function show(string $product_id, ?string $admin=null)
    {
        $product = $this->_productService->retrieve($product_id, $admin);
        
        return $product ? response()->json([
            'response_status' => 'success', 'message' => 'product retrieved successfully', 'data' => ['product' => $product]
            ]) : response()->json(['request_status' => 'failure', 'message' => 'product retrieve failed']);
    }

    public function store(Request $request)
    {
        $data = $request->json()->all();
        
        $addedProductData = $this->_productService->add($data);

        return $addedProductData ? response()->json([
            'response_status' => 'success', 'message' => 'product added successfully', "data" => ['addedProduct' => $addedProductData]
        ]) : response()->json(['response_status' => 'failure', 'message' => 'product adding failed']);
    }

    public function update(string $product_id, Request $request)
    {
        $data = $request->json()->all();

        $updatedProductData = $this->_productService->update($product_id, $data);

        return $updatedProductData ? response()->json([
            'response_status' => 'success', 'message' => 'product updated successfully', "data" => ['updatedProduct' => $updatedProductData]
        ]) : response()->json(['response_status' => 'failure', 'message' => 'product update failed']);
    }

    public function addCategories(Request $request, string $productId)
    {
        $data = $request->json()->all();

        $productData = $this->_productService->associateWithCategories($productId, $data);

        return $productData ? response()->json([
            'response_status' => 'success', 'message' => 'product associated with categories successfully', 'data' => ['product' => $productData]
        ]) : response()->json(['reponse_status' => 'failure', 'message' => 'product and categories association failed']);
    }
    
    public function removeCategories(Request $request, string $productId)
    {
        $data = $request->json()->all();

        $productData = $this->_productService->dissociateCategories($productId, $data);

        return $productData ? response()->json([
            'response_status' => 'success', 'message' => 'product dissociated with categories successfully', 'data' => ['product' => $productData]
        ]) : response()->json(['reponse_status' => 'failure', 'message' => 'product and categories dissociation failed']);
    }

    public function remove(string $productId)
    {
        $removedSuccessfully = $this->_productService->remove($productId);

        return $removedSuccessfully ? response()->json([
            'response_status' => 'success', 'message' => 'product removed successfully'
        ]) : response()->json(['response_status' => 'failure', 'message' => 'product remove failed']);
    }
}