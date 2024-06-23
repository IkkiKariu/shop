<?php

namespace App\Services;
use App\Models\Price;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class PriceService
{
    public function retrieveAll(string $productId)
    {
        try
        {
            $prices = Price::where('product_id', $productId)->get();
        }
        catch (QueryException $ex)
        {
            return null;
        }

        return $prices ? $prices->toArray() : null;
    }

    public function retrieve(string $id)
    {
        $price = $this->getModelIfExists($id);

        return $price ? $price->toArray() : null;
    }

    public function add(string $productId, array $priceData)
    {
        try
        {
            $product = Product::where('id', $productId)->first();
        }
        catch (QueryException $ex)
        {
            return null;
        }

        if (!$product) { return null; }

        $validatedSucced = $this->validateData($priceData);
        if (!$validatedSucced) { return null; }

        $newPrice = new Price();
        $newPrice->product_id = $productId;
        $newPrice->condition = $priceData['condition'];
        $newPrice->value = $priceData['value'];
        $newPrice->save();

        return $this->retrieve($newPrice->id);
    }

    public function update(string $id, ?array $priceData)
    {
        $price = $this->getModelIfExists($id);
        if (!$price) { return null; }

        $validatedSucced = $this->validateData($priceData);
        if (!$validatedSucced) { return null; }

        $price->condition = $priceData['condition'];
        $price->value = $priceData['value'];
        $price->save();

        return $price->toArray();
    }

    public function remove(string $id)
    {
        $price = $this->getModelIfExists($id);
        if (!$price) { return false; }

        $price->delete();

        return true;
    }

    private function getModelIfExists(string $id)
    {
        try
        {
            $price = Price::where('id', $id)->first();
        }
        catch (QueryException)
        {
            return null;
        }

        return $price ? $price : null;
    }

    private function validateData(array $data)
    {
        $validationRules = [
            'condition' => 'max:255|required|string|min:1',
            'value' => 'decimal:2|required'
        ];

        $validator = Validator::make($data, $validationRules);

        if ($validator->fails()) { return false; }

        return true;
    }
}