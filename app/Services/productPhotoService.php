<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategoryRelationship;
use App\Models\ProductPhoto;
use Illuminate\Support\Facades\Storage;
use App\Models\Property;
use Illuminate\Database\Events\QueryExecuted;
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


    public function retrieve(string $id)
    {
        $productPhotoModel = $this->getModelIfExists($id);
        if (!$productPhotoModel) { return null; }

        if(!Storage::disk('local')->exists($productPhotoModel->path)) { return null; }

        return Storage::download($productPhotoModel->path);
    }

    public function retrieveAll(string $productId)
    {
        try
        {
            $productPhotoModels = ProductPhoto::where('product_id', $productId)->get();
            if(!$productPhotoModels) { return null; }
        }
        catch (QueryException $ex)
        {
            return null; 
        }

        $productPhotoIdList = [];

        foreach ($productPhotoModels as $productPhotoModel)
        {
            $productPhotoIdList[] = $productPhotoModel->id;
        }

        return $productPhotoIdList;
    }

    public function remove(string $id)
    {
        $productPhotoModel = $this->getModelIfExists($id);
        if (!$productPhotoModel) { return false; }

        if (!Storage::disk('local')->exists($productPhotoModel->path)) { return false; }

        Storage::disk('local')->delete($productPhotoModel->path);
        $productPhotoModel->delete();

        return true;
    }

    private function getModelIfExists(string $id)
    {
        try
        {
            $productPhoto = ProductPhoto::where('id', $id)->first();
            if (!$productPhoto) { return null; }
        }
        catch (QueryException $ex)
        {
            return null;
        }

        return $productPhoto;
    }
}