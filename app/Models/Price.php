<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Price extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'prices';

    protected $fillable = ['product_id' ,'condition', 'value'];

    protected function casts(): array
    {
        return [
            'value' => 'decimal:2'
        ];
    }
}
