<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PropertyService;

class PropertyController extends Controller
{
    private PropertyService $_propertyService;

    public function __construct(PropertyService $propertyService)
    {
        $this->_propertyService = $propertyService;
    }

    public function index(string $productId)
    {
        $properties = $this->_propertyService->retrieveAll($productId);

        return $properties ? response()->json([
            'response_status' => 'success', 'message' => 'product properties retrieved successfully', 'data' => ['properties' => $properties]
        ]) : response()->json(['response_status' => 'failure', 'message' => 'product properties retrieving failed']);
    }

    public function show(string $propertyId)
    {
        $property = $this->_propertyService->retrieve($propertyId);

        return $property ? response()->json([
            'response_status' => 'success', 'message' => 'product property retrieved successfully', 'data' => ['property' => $property]
        ]) : response()->json(['response_status' => 'failure', 'message' => 'product property retrieve failed']);
    }

    public function store(Request $request, string $productId)
    {
        $data = $request->json()->all();

        $newProperty = $this->_propertyService->add($productId, $data);

        return $newProperty ? response()->json([
            'response_status' => 'success', 'message' => 'property added to product successfully', 'data' => ['newProperty' => $newProperty]
        ]) : response()->json(['response_status' => 'failure', 'message' => 'adding property to product  failed']);
    }

    public function update(Request $request, string $propertyId)
    {
        $data = $request->json()->all();

        $updatedProperty = $this->_propertyService->update($propertyId, $data);

        return $updatedProperty ? response()->json([
            'response_status' => 'success', 'message' => 'product property updated successfully', 'data' => ['updatedProperty' => $updatedProperty]
        ]) : response()->json(['response_status' => 'failure', 'message' => 'product property update failed']);
    }

    public function remove(string $propertyId)
    {
        $removedSuccessfully = $this->_propertyService->remove($propertyId);

        return $removedSuccessfully ? response()->json([
            'response_status' => 'success', 'message' => 'product property removed successfully'
        ]) : response()->json(['response_status' => 'failure', 'message' => 'product property remove failed']);
    }
} 
