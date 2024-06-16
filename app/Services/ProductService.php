<?php

namespace App\Services;
use App\Models\Category;
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
                    $productList[] = Product::where('id', $value->product_id)->first()->toArray();
                }
            }
        }
        else
        {
            $products = Product::get();

            if($products)
            {
                $productList = $products->toArray();
            }
        }

        return $productList;
    }

    public function retrieve(string $id)
    {

        // product id format invalid
        try 
        {
            $product = Product::where('id', $id)->first();
        }
        catch(QueryException $ex)
        {
            return null;
        }
        

        // product with given $id doesn't exist
        if(!$product) { return null; }

        $productData = $product->toArray();

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

        return $productData;
    }

    public function add(?array $productData) // todo: move categories existense check before products table entry creation; write properties table entries creation logic
    {
        $validationSucced = $this->validateProductData($productData);
        
        // validation failure
        if(!$validationSucced) { return false; }

        // create products table entry
        $newProduct = new Product();
        $newProduct->name = $productData['name'];
        
        if(key_exists('description', $productData)) { $newProduct->description = $productData['description']; }

        $newProduct->save();

        // associate added product with given categories
        $categories = array_unique($productData['categories']);

        // check if some of given categories doesn't exisit
        foreach ($categories as $key => $value)
        {
            $guessedCategory = Category::where('name', $value)->first();

            if(!$guessedCategory) { return false; }
        }
        
        //create product_category_relationships table entry
        foreach ($categories as $key => $value)
        {
            $category = Category::where('name', $value)->first();

            $product_category_relation = new ProductCategoryRelationship();
            $product_category_relation->product_id = $newProduct->id;
            $product_category_relation->category->id = $category->id;
            $product_category_relation->save();
        }

    }

    public function update(string $name, string|null $description, array|null $categories, array|null $properties)
    {

    }

    public function delete(string $id)
    {
        
    }

    private function validateProductData(?array $productData): bool
    {
        if (!$productData) { return false; }

        $validationRules = [
            'name' => 'required|max:127|string|min:2',
            'description' => 'max:255|string|min:5',
            'categories' => 'required|array|min:3',
            'categories.*' => 'required|string|max:127',
            'properties' => 'array',
            'properties.*.name' => 'max:127|required|string',
            'properties.*.value' => 'max:127|required|string'
        ];

        $validator = Validator::make($productData, $validationRules);

        if($validator->fails()) { return false; }

        return true;
    }
}