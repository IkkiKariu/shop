<?php

namespace App\Http\Controllers;

use App\Services\ProductPhotoService;
use Illuminate\Http\Request;

class ProductPhotoController extends APIController
{
    private $_productPhotoService;

    public function __construct(ProductPhotoService $productPhotoService) {
        $this->_productPhotoService = $productPhotoService;
    }

    public function index()
    {

    }

    public function store(Request $request, string $productId)
    {
        if(!$request->hasFile('product_photos'))
        {
            return response()->json(
                ['response_status' => 'failure', 'message' => 'Product title photo adding failed']
            );
        }

        $files = $request->file('product_photos');

        if(!is_array($files)) 
        { 
            return response()->json(
                ['response_status' => 'failure', 'message' => 'Product title photo adding failed']
            ); 
        }

        $productPhotoIdList = $this->_productPhotoService->add($productId, $files);

        return response()->json($productPhotoIdList);
    }

    public function remove()
    {

    }
}
