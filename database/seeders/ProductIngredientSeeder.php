<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Product;
use App\Models\ProductIngredient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductIngredientSeeder extends Seeder
{
    public const PRODUCT_INGREDIENTS = [
        'beef' => '150',
        'cheese' => '30',
        'onion' => '20',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product = Product::firstOrCreate(['name' => 'Burger'],
                    ['name' => 'Burger']);

        Ingredient::all()
        ->map(function(Ingredient $ingredient) use ($product) {
            if ($product->ingredients()
                ->wherePivot('ingredient_id', $ingredient->id)
                ->exists())
            {
                return;
            }

            $product->ingredients()->attach($ingredient->id,
                ['quantity' =>
                    self::PRODUCT_INGREDIENTS[strtolower($ingredient->name)]
                ]);
        });
    }
}
