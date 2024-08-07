<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Product;
use App\Models\Category;

class ProductCategoryRelationship extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'product_category_relationships';

    protected $fillable = ['product_id', 'category_id'];

    public $timestamps = false;

    public function product(): HasOne 
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function category(): HasOne
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
