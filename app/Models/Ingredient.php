<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'quantity_available',
        'quantity_supplied',
        'quantity_stocked',
        'last_reorder_at'
    ];

    public function merchant(): BelongsTo
    {
        return $this->BelongsTo(Merchant::class, 'user_id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_ingredients')
                ->withPivot('id', 'quantity');
    }

    public function reorderNotifications(): HasMany
    {
        return $this->hasMany(ReorderNotification::class);
    }

    public function isMerchantNotifiedForReorder(): bool
    {
        return $this->reorderNotifications()
            ->where('last_reorder_at', $this->last_reorder_at)
            ->exists();
    }

    public function isDueForReorder(): bool
    {
        $half = $this->quantity_stocked / 2;
        $diff = $this->quantity_stocked - $this->quantity_available;

        return $half <= $diff;
    }
}
