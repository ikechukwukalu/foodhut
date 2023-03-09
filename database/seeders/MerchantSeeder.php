<?php

namespace Database\Seeders;

use App\Models\Merchant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MerchantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Merchant::firstOrCreate(
            ['email' => 'testmerchant@xyz.com'],
            [
                'name' => 'Test Merchant',
                'email' => 'testmerchant@xyz.com'
            ]);
    }

}
