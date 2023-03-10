<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReorderNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'ingredient_id',
        'quantity_left',
        'last_reorder_at'
    ];

    public function ingredient(): BelongsTo
    {
        return $this->BelongsTo(Ingredient::class);
    }
}
