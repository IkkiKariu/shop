<?php

namespace App\Http\Controllers;

use App\Models\ProductPhoto;
use App\Services\ProductPhotoService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductPhotoController extends APIController
{
    private $_productPhotoService;

    public function __construct(ProductPhotoService $productPhotoService) {
        $this->_productPhotoService = $productPhotoService;
    }

    public function index(string $productId)
    {
        $productPhotos = $this->_productPhotoService->retrieveAll($productId);

        return $productPhotos ? response()->json([
            'response_status' => 'success', 'message' => 'product photos` uuids retrieved successfully', 'data' => ['productPhotoIdList' => $productPhotos]
        ]) : response()->json(['response_status' => 'failure', 'message' => 'product photos`uuids retrieve failed']);
    }

    public function store(Request $request, string $productId)
    {
        if(!$request->hasFile('product_photos'))
        {
            return response()->json(
                ['response_status' => 'failure', 'message' => 'Product photos adding failed']
            );
        }

        $files = $request->file('product_photos');

        if(!is_array($files)) 
        { 
            return response()->json(
                ['response_status' => 'failure', 'message' => 'Product photos adding failed']
            ); 
        }

        $productPhotoIdList = $this->_productPhotoService->add($productId, $files);

        return $productPhotoIdList ? response()->json([
            'response_status' => 'success', 'message' => 'product photos added successfully', 'data' => ['productPhotoIdList' => $productPhotoIdList]
        ]) : response()->json(['response_status' => 'failure', 'message' => 'product photo adding failed']);
    }

    public function show(Request $request, $productPhotoId)
    {
        $response = $this->_productPhotoService->retrieve($productPhotoId);

        return $response ? $response : response()->json(['response_status' => 'failure', 'message' => 'product photo retrieving failed']);
    }

    public function remove(string $productPhotoId)
    {
        $removedSuccessfully = $this->_productPhotoService->remove($productPhotoId);

        return $removedSuccessfully ? response()->json([
            'response_status' => 'success', 'message' => 'product photo removed successfuly'
        ]) : response()->json(['response_status' => 'failure', 'message' => 'failed to remove product photo']);
    }
}
