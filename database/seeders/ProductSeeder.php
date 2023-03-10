<?php

namespace Database\Seeders;

use App\Models\Merchant;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $merchant = Merchant::merchant()->first();

        Product::firstOrCreate(
            ['name' => 'Burger'],
            [
                'name' => 'Burger',
                'user_id' => $merchant->id
            ]);
    }
}
