<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ingredient::firstOrCreate(
            ['name' => 'Beef'],
            [
                'name' => 'Beef',
                'quantity_available' => '20000',
                'quantity_supplied' => '20000',
                'quantity_stocked' => '20000',
            ]);

        Ingredient::firstOrCreate(
            ['name' => 'Cheese'],
            [
                'name' => 'Cheese',
                'quantity_available' => '5000',
                'quantity_supplied' => '5000',
                'quantity_stocked' => '5000',
            ]);

        Ingredient::firstOrCreate(
            ['name' => 'Onion'],
            [
                'name' => 'Onion',
                'quantity_available' => '1000',
                'quantity_supplied' => '1000',
                'quantity_stocked' => '1000',
            ]);
    }
}
