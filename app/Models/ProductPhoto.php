<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPhoto extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'product_photos';

    protected $fillable = ['product_id', 'path'];

    public $timestamps = false;
}
