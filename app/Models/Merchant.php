<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Merchant extends User
{
    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_merchant'
    ];

    public function scopeMerchant(Builder $query): void
    {
        $query->where('is_merchant', true);
    }

    public function setIsMerchantAttribute($value)
    {
        $this->attributes['is_merchant'] = true;
    }

    public function ingredients(): HasMany
    {
        return $this->hasMany(Ingredient::class, 'user_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'user_id');
    }

    public function productIngredients(): HasMany
    {
        return $this->hasMany(ProductIngredient::class, 'user_id');
    }
}
