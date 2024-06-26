<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'properties';

    protected $fillable = ['product_id', 'name', 'value'];

    public $timestamps = false;
}
