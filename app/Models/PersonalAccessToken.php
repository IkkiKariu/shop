<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\User;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    use HasFactory;

    public $keyType = 'string';

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'tokenable_id');
    }
}