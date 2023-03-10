<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductIngredient extends Model
{
    use HasFactory;

    protected $table = 'product_ingredients';

    protected $fillable = [
        'user_id',
        'product_id',
        'ingredient_id',
        'quantity'
    ];

    public function merchant(): BelongsTo
    {
        return $this->BelongsTo(Merchant::class, 'user_id');
    }
}
