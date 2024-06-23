<?php

namespace App\Services;

use App\Models\Property;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class PropertyService
{
    public function retrieveAll(string $productId)
    {
        try
        {
            $properties = Property::where('product_id', $productId)->get();
        }
        catch (QueryException $ex)
        {
            return null;
        }

        return $properties ? $properties->toArray() : null;
    }

    public function retrieve(string $id)
    {
        $property = $this->getModelIfExists($id);

        return $property ? $property->toArray() : null;
    }

    public function add(string $productId, ?array $propertyData)
    {
        try
        {
            $product = Product::where('id', $productId)->get();
        }
        catch (QueryException $ex)
        {
            return null;
        }

        if (!$product) { return null; }

        $validatedSucced = $this->validateData($propertyData);
        if(!$validatedSucced) { return null; }

        $property = new Property();
        $property->product_id = $productId;
        $property->name = $propertyData['name'];
        $property->value = $propertyData['value'];
        $property->save();

        return $property->toArray();
    }

    public function update(string $id, ?array $propertyData)
    {
        $property = $this->getModelIfExists($id);

        if(!$property) { return null; }

        $validatedSucced = $this->validateData($propertyData);
        if (!$validatedSucced) { return null; }

        $property->name = $propertyData['name'];
        $property->value = $propertyData['value'];
        $property->save();

        return $property->toArray();
    }

    public function remove(string $id)
    {
        $property = $this->getModelIfExists($id);
        if (!$property) { return false; }

        $property->delete();

        return true;
    }

    private function getModelIfExists(string $id)
    {
        try
        {
            $property = Property::where('id', $id)->first();
        }
        catch (QueryException $ex)
        {
            return null;
        }

        if (!$property) { return false; }

        return $property;
    }

    private function validateData(?array $data)
    {
        if (!$data) { return false; }

        $valdiationRules = [
            'name' => 'max:127|required|string|min:1',
            'value' => 'max:127|required|string|min:1'
        ];

        $validator = Validator::make($data, $valdiationRules);

        if ($validator->fails()) { return false; }

        return true;
    }
}