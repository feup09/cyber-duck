<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'Sales Agent',
            'email' => 'sales@coffee.shop',
        ]);

        Product::create([
            'name' => 'Gold coffe',
            'profit_margin' => 25,
        ]);

        Product::create([
            'name' => 'Arabic coffe',
            'profit_margin' => 15,
        ]);
    }
}
