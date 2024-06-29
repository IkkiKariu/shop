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
        $prices = $this->_priceService->retrieveAll($productId);

        return $prices ? response()->json([
            'response_status' => 'success', 'message' => 'product prices retrieved succesfully', 'data' => ['productPrices' => $prices]
        ]) : response()->json(['response_status' => 'failure', 'message' => 'product prices retrieve failed']);
    }

    public function show(string $priceId)
    {
        $price = $this->_priceService->retrieve($priceId);

        return $price ? response()->json([
            'response_status' => 'success', 'message' => 'price data retrieved succesfully', 'data' => ['priceData' => $price]
        ]) : response()->json(['response_status' => 'failure', 'message' => 'price data retrieve failed']);
    }

    public function store(Request $request, string $productId)
    {
        $data = $request->json()->all();

        $newPrice = $this->_priceService->add($productId, $data);

        return $newPrice ? response()->json([
            'response_status' => 'success', 'message' => 'product price added succesfully', 'data' => ['productPrice' => $newPrice]
        ]) : response()->json(['response_status' => 'failure', 'message' => 'product price adding failed']);
    }

    public function update(Request $request, string $priceId)
    {
        $data = $request->json()->all();

        $updatedPrice = $this->_priceService->update($priceId, $data);

        return $updatedPrice ? response()->json([
            'response_status' => 'success', 'message' => 'price updated succesfully', 'data' => ['updatedPrice' => $updatedPrice]
        ]) : response()->json(['response_status' => 'failure', 'message' => 'price update failed']);
    }

    public function remove(string $priceId)
    {
        $removedSuccessfully = $this->_priceService->remove($priceId);

        return $removedSuccessfully ? response()->json([
            'response_status' => 'success', 'message' => 'price removed succesfully'
        ]) : response()->json(['response_status' => 'failure', 'message' => 'price remove failed']);
    }
}
