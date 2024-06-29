<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Price;
use App\Models\Product;
use App\Models\ProductCategoryRelationship;;
use App\Models\Property;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class ProductService
{
    public function retrieveAll(?string $category=null)
    {
        $productList = array();

        if($category)
        {
            $category = Category::where('name', $category)->first();

            // category with given name doesn't exist
            if(!$category) { return null; }

            // get products which related to given category
            $relations = ProductCategoryRelationship::where('category_id', $category->id)->get();

            if($relations)
            {
                foreach ($relations as $key => $value)
                {
                    $productList[] = Product::with('prices')->where('id', $value->product_id)->first()->toArray();
                }
            }
        }
        else
        {
            $products = Product::with('prices')->get();

            if($products)
            {
                $productList = $products->toArray();
            }
        }

        return $productList;
    }

    public function retrieve(string $id, ?string $admin = null)
    {
        // product id format is invalid
        try 
        {
            $product = Product::where('id', $id)->first();
        }
        catch(QueryException $ex)
        {
            return null;
        }

        $productData = $product->toArray();

        // product with given $id doesn't exist
        if(!$product) { return null; }

        // retrieve data for simple display
        if(!$admin)
        {
            // retrieve product categories
            $relations = ProductCategoryRelationship::with('category')->where('product_id', $id)->get()->toArray();

            $productCategoryList = array();
            foreach ($relations as $key => $value)
            {
                $productCategoryList[] = [
                    'id' => $value['category']['id'], 
                    'name' => $value['category']['name'], 
                    'description' => $value['category']['description']
                ];
            }

            $productData['categories'] = $productCategoryList;

            // retrieve product properties
            $properties = Property::where('product_id', $product->id)->get();

            $propertyList = array();

            if($properties)
            {    
                foreach ($properties as $key => $value)
                {
                    $propertyList[] = ['name' => $value->name, 'value' => $value->value];
                }
            }

            $productData['properties'] = $propertyList;

            // retrieve product prices
            $priceList = array();

            $prices = Price::where('product_id', $id)->get();

            foreach ($prices as $price)
            {
                $priceList[] = ['condition' => $price->condition, 'value' => $price->value];
            }

            $productData['prices'] = $priceList;
        }
        else // retrieve data for admin panel
        {
            // retrieve categories from database
            $categoryList = [];

            $relations = ProductCategoryRelationship::where('product_id', $id)->get();
            foreach ($relations as $relation)
            {
                $categoryList[] = Category::where('id', $relation->category_id)->first()->toArray();
            }
            $productData['categories'] = $categoryList;

            // retrieve properties from database
            $properties = Property::where('product_id', $id)->get();
            $productData['properties'] = $properties ? $properties->toArray() : [];

            // retrieve prices from database
            $productData['prices'] = Price::where('product_id', $id)->get()->toArray();
        }

        return $productData;
    }

    public function add(?array $productData)
    {
        $validationSucced = $this->validateProductData($productData);
        
        // validation failure
        if(!$validationSucced) { return null; }

        // remove category dublicates
        $categories = array_unique($productData['categories']);

        // check if some of given categories doesn't exisit
        foreach ($categories as $key => $value)
        {
            $guessedCategory = Category::where('name', $value)->first();

            if(!$guessedCategory) { return null; }
        }

        // create products table entry
        $newProduct = new Product();
        $newProduct->name = $productData['name'];
        
        if(key_exists('description', $productData)) { $newProduct->description = $productData['description']; }

        $newProduct->save();
        
        //create product_category_relationships table entries

        foreach ($categories as $key => $value)
        {
            $category = Category::where('name', $value)->first();

            $product_category_relation = new ProductCategoryRelationship();
            $product_category_relation->product_id = $newProduct->id;
            $product_category_relation->category_id = $category->id;
            $product_category_relation->save();
        }

        // create properties table entries
        if(key_exists('properties', $productData))
        {
            $properties = $productData['properties'];

            foreach ($properties as $property)
            {
                $newProperty = new Property();
                $newProperty->product_id = $newProduct->id;
                $newProperty->name = $property['name'];
                $newProperty->value = $property['value'];
                $newProperty->save();
            }
        }

        // create prices table entries
        $prices = $productData['prices'];

        foreach ($prices as $price)
        {
            $newPrice = new Price();
            $newPrice->product_id = $newProduct->id;
            $newPrice->condition = $price['condition'];
            $newPrice->value = $price['value'];
            $newPrice->save();
        }

        return $this->retrieve(id: $newProduct->id, admin: 'yes')   ;
    }

    public function update(string $id, ?array $productData)
    {
        $product = $this->getModelIfExists($id);

        if(!$product) { return null; }
        if(!$productData) { return null; }

        $validationRules = [
            'name' => 'required|max:127|string|min:2',
            'description' => 'max:255|string|min:5'
        ];
        $validator = Validator::make($productData, $validationRules);
        if ($validator->fails()) { return null; }

        $product->name = $productData['name'];
        if (key_exists('description', $productData))
        {
            $product->description = $productData['description'];
        }
        $product->save();

        return $product->toArray();
    }

    public function remove(string $id)
    {
        $product = $this->getModelIfExists($id);
        
        if (!$product) { return false; }

        $product->delete();

        return true;
    }

    private function getModelIfExists(string $id)
    {
        try
        {
            $product = Product::where('id', $id)->first();
        }
        catch (QueryException $ex)
        {
            return null;
        }

        return $product ? $product : null;
    }

    private function validateProductData(?array $productData): bool
    {
        if (!$productData) { return false; }

        $validationRules = [
            'name' => 'required|max:127|string|min:1',
            'description' => 'max:255|string|min:1',
            'categories' => 'required|array',
            'categories.*' => 'required|string|max:127|min:1',
            'properties' => 'array',
            'properties.*.name' => 'max:127|required|string|min:1',
            'properties.*.value' => 'max:127|required|string|min:1',
            'prices' => 'required|array',
            'prices.*.condition' => 'max:255|required|string|min:1',
            'prices.*.value' => 'decimal:2|required'
        ];

        $validator = Validator::make($productData, $validationRules);

        if($validator->fails()) { return false; }

        foreach ($productData['prices'] as $price)
        {
            if(strlen(explode('.', $price['value'])[0]) > 9) { return false; }
        }

        return true;
    }
}   