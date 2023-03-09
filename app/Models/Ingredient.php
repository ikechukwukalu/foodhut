<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id',
        'name',
        'quantity_available',
        'quantity_supplied',
        'quantity_stocked',
        'last_reorder_at'
    ];

    public function merchant(): BelongsTo
    {
        return $this->BelongsTo(Merchant::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_ingredients');
    }
}
