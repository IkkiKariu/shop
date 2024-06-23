<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use Illuminate\Database\QueryException;

class CategoryService
{
    public function add(?array $categoryData)
    {
        $validatedSucced = $this->validateData($categoryData);

        if(!$validatedSucced) { return null; }

        $newCategory = new Category();
        $newCategory->name = $categoryData['name'];
        $newCategory->description = key_exists('description', $categoryData) ? $categoryData['description'] : null;
        $newCategory->save();

        return $this->retrieve($newCategory->id);
    }

    public function retrieveAll()
    {
        $categories = Category::all();

        return $categories ? $categories->toArray() : null;
    }

    public function retrieve(string $id)
    {
        // category id format is invalid
        try 
        {
            $category = Category::where('id', $id)->first();
        }
        catch(QueryException $ex)
        {
            return null;
        }

        // category with given id doesn't exist
        if(!$category) { return null; }

        return $category->toArray();
    }

    public function update(string $id, ?array $categoryData)
    {
        // category id format is invalid
        try 
        {
            $category = Category::where('id', $id)->first();
        }
        catch(QueryException $ex)
        {
            return null;
        }

        // category with given id doesn't exists
        if (!$category) { return null; }

        $validatedSucced = $this->validateData($categoryData);

        if(!$validatedSucced) { return null; }

        $category->name = $categoryData['name'];
        $category->description = $categoryData['description'] ? $categoryData['description'] : null;
        $category->save();

        return $this->retrieve($id);
    }

    public function remove(string $id)
    {
        // category id format is invalid
        try 
        {
            $category = Category::where('id', $id)->first();
        }
        catch(QueryException $ex)
        {
            return false;
        }

        // category with given id doesn't exist
        if(!$category) { return false; }

        $category->delete();

        return true;
    }

    private function validateData(?array $categoryData)
    {
        if (!$categoryData) { return false; }

        $validationRules = [
            'name' => 'required|string',
            'description' => 'string'
        ];

        $validator = Validator::make($categoryData, $validationRules);

        if($validator->fails()) { return false; }

        return true;
    }
}