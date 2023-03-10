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
     * Handle The Request.
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
            return ['fail', 422, ['message' => trans('order.no_product')]];
        }

        return self::getOrders($products);
    }

    /**
     * Add Order To Collection.
     *
     * @param array $validated
     * @return void
     */
    private static function addOrderToCollection(array $validated): void
    {
        self::$orderCollection = collect($validated['products']);
    }

    /**
     * Filter ProductIDs.
     *
     * @param array $validated
     * @return array
     */
    private static function filterProductIDs(array $validated): array
    {
        self::addOrderToCollection($validated);
        return explode(",", self::$orderCollection->implode('product_id', ', '));
    }

    /**
     * Get Products.
     *
     * @param array $productIDs
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private static function getProducts(array $productIDs): ?EloquentCollection
    {
        return Product::whereIn('id', $productIDs)->get();
    }

    /**
     * Get Order Row.
     *
     * @param \App\Models\Product $product
     * @return array
     */
    private static function getOrderRow(Product $product): array
    {
        $row = ['product_id' => $product->id, 'quantity' => 0];
        $orderRows = self::$orderCollection->where('product_id', $product->id);

        foreach ($orderRows as $orderRow) {
            $row['quantity'] += $orderRow['quantity'];
        }

        return $row;
    }

    /**
     * Get Product Ingredients.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private static function getProductIngredients(Product $product): ?EloquentCollection
    {
        $row = self::getOrderRow($product);

        if (!$ingredients = $product->ingredients()->get()) {
            /**
             * This means that an order will fail because
             * there are no ingredients.
             *
             * Here an event can be dispatched to notify the
             * merchant that an order has failed, also specifying
             * the reason why it failed.
             */
            return null;
        }

        foreach ($ingredients as $ingredient) {
            $quantity = $row['quantity'] * $ingredient->pivot->quantity;

            if ($ingredient->quantity_available < $quantity)
            {
                /**
                 * This means that an order will fail because
                 * a certain ingredient is lacking in quantity.
                 *
                 * Here an event can be dispatched to notify the
                 * merchant that an order has failed, also specifying
                 * the reason why it failed.
                 */
                return null;
            }
        }

        return $ingredients;
    }

    /**
     * Save Order.
     *
     * @param \App\Models\Product $product
     * @param \bool $status
     * @return \App\Models\Order
     */
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

    /**
     * Process Order.
     *
     * @param \App\Models\Product $product
     * @return \App\Models\Order
     */
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

    /**
     * Update Ingredient Quantity.
     *
     * @param \App\Models\Product $product
     * @param \App\Models\Ingredient $ingredient
     * @return void
     */
    private static function updateIngredientQuantity(Product $product, Ingredient $ingredient): void
    {
        $row = self::getOrderRow($product);
        $quantity_taken = $row['quantity'] * $ingredient->pivot->quantity;

        $ingredient->update([
            'quantity_available' => $ingredient->quantity_available - $quantity_taken
        ]);

        ReorderLevel::dispatch($ingredient);
    }

    /**
     * Get Orders.
     *
     * @param \Illuminate\Database\Eloquent\Collection $products
     * @return null
     * @return \Illuminate\Support\Collection
     */
    private static function getOrders(EloquentCollection $products): null|Collection
    {
        return $products->map(function(Product $product) {
            return self::processOrder($product);
        });
    }
}
