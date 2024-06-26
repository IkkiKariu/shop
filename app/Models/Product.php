<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Property;
use App\Models\Price;

class Product extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'products';

    protected $fillable = ['name', 'description'];

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class, 'product_id', 'id');
    }

    public function prices(): HasMany
    {
        return $this->hasMany(Price::class, 'product_id', 'id');
    }
}
