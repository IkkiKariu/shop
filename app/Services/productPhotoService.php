<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategoryRelationship;
use App\Models\ProductPhoto;

;
use App\Models\Property;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\UploadedFile;

class ProductPhotoService
{
    public function add(string $productId, array $photos)
    {
        // product with given id doesn't exist
        try 
        {
            $guessedProoduct = Product::where('id', $productId)->first();
            if(!$guessedProoduct) { return null; }
        }
        catch (QueryException $ex) 
        {
            return null;
        }

        // check that files are valid
        foreach ($photos as $photo)
        {
            if(!$photo->isValid()) { return null; }

            if(!($photo->extension() == 'jpg' || $photo->extension() == 'png')) 
            {
                return null;
            }
        }

        // add photos
        $productPhotoUuids = [];
        
        foreach ($photos as $photo)
        {
            // store photos
            $filepath = $photo->store('product_photos', 'local');

            // create product photos table entries
            $newProductPhoto = new ProductPhoto();
            $newProductPhoto->product_id = $productId;
            $newProductPhoto->path = $filepath;
            $newProductPhoto->save();

            $productPhotoUuids[] = $newProductPhoto->id;
        }

        return $productPhotoUuids;
    }


    public function retrieve(string $productPhotoId)
    {
        
    }

    public function retrieveAll(string $productId)
    {

    }

    // public function update(string $productId, mixed $photos)
    // {
        
    // }

    public function delete(string $productId, mixed $photos)
    {
        
    }
}