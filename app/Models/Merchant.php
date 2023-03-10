<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Merchant extends User
{

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_merchant'
    ];

    public function ingredients(): HasMany
    {
        return $this->hasMany(Ingredient::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
