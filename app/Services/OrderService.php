<?php

namespace App\Services;

use App\Events\ReorderLevel;
use App\Http\Requests\OrderRequest;
use App\Models\Ingredient;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductIngredient;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    private static User $user;
    private static Collection $orderCollection;

    /**
     * Handle the request.
     *
     * @param  \App\Http\Requests\OrderRequest  $request
     * @return null|array|\Illuminate\Support\Collection
     */
    public static function handleOrder(OrderRequest $request): null|array|Collection
    {
        self::$user = Auth::user();
        $validated = $request->validated();
        $productIDs = self::filterProductIDs($validated);

        if (!$products = self::getProducts($productIDs)) {
            return ['fail', 422, ['message' => 'No product was found']];
        }

        $orders = $products->map(function(Product $product) {
            return self::processOrder($product);
        });

        return $orders;
    }

    private static function addOrderToCollection(array $validated): void
    {
        self::$orderCollection = collect([$validated['products']]);
    }

    private static function filterProductIDs(array $validated): array
    {
        self::addOrderToCollection($validated);
        return explode(",", self::$orderCollection->implode('product_id', ', '));
    }

    private static function getProducts(array $productIDs): ?EloquentCollection
    {
        return Product::whereIn('id', $productIDs)->get();
    }

    private static function getOrderRow(Product $product): array
    {
        return self::$orderCollection->firstWhere('product_id', $product->id);
    }

    private static function getProductIngredients(Product $product): ?EloquentCollection
    {
        $row = self::getOrderRow($product);

        if (!$ingredients = $product->ingredients()->get()) {
            return null;
        }

        foreach ($ingredients as $ingredient) {
            $quantity = $row['quantity'] * $ingredient->pivot->quantity;

            if ($ingredient->quantity_available < $quantity)
            {
                return null;
            }
        }

        return $ingredients;
    }

    private static function saveOrder(Product $product, bool $status = true): Order
    {
        $row = self::getOrderRow($product);

        return Order::create([
            'user_id' => self::$user->id,
            'product_id' => $product->id,
            'quantity' => $row['quantity'],
            'is_successful' => $status
        ]);
    }

    private static function processOrder(Product $product): Order
    {
        $ingredients = self::getProductIngredients($product);

        if (!$ingredients) {
            return self::saveOrder($product, false);
        }

        foreach ($ingredients as $ingredient) {
            self::updateIngredientQuantity($product, $ingredient);
        }

        return self::saveOrder($product);
    }

    private static function updateIngredientQuantity(Product $product, Ingredient $ingredient): void
    {
        $row = self::getOrderRow($product);
        $quantity_taken = $row['quantity'] * $ingredient->pivot->quantity;

        $ingredient->update([
            'quantity_available' => $ingredient->quantity_available - $quantity_taken
        ]);

        ReorderLevel::dispatch($ingredient);
    }
}
