<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Merchant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $merchant = Merchant::merchant()->first();

        Ingredient::firstOrCreate(
            ['name' => 'Beef'],
            [
                'name' => 'Beef',
                'quantity_available' => '20000',
                'quantity_supplied' => '20000',
                'quantity_stocked' => '20000',
                'user_id' => $merchant->id
            ]);

        Ingredient::firstOrCreate(
            ['name' => 'Cheese'],
            [
                'name' => 'Cheese',
                'quantity_available' => '5000',
                'quantity_supplied' => '5000',
                'quantity_stocked' => '5000',
                'user_id' => $merchant->id
            ]);

        Ingredient::firstOrCreate(
            ['name' => 'Onion'],
            [
                'name' => 'Onion',
                'quantity_available' => '1000',
                'quantity_supplied' => '1000',
                'quantity_stocked' => '1000',
                'user_id' => $merchant->id
            ]);
    }
}
