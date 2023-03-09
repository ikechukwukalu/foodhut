<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Merchant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
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
