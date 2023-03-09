<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductIngredient extends Model
{
    use HasFactory;

    protected $table = 'product_ingredients';

    protected $fillable = [
        'product_id',
        'ingredient_id',
        'quantity'
    ];
}
