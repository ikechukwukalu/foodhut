<?php

namespace Database\Seeders;

use App\Models\Merchant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

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
                'email' => 'testmerchant@xyz.com',
                'email_verified_at' => now(),
                'password' => Hash::make(Str::random(10)),
                'remember_token' => Str::random(10),
                'is_merchant' => true,
            ]);
    }

}
