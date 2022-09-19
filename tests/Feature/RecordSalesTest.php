<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Tests\TestCase;

class RecordSalesTest extends TestCase
{

    public function test_record_sales()
    {
        $user = User::factory()->create();

        $tests = [
            [
                'quantity' => 1,
                'unitCost' => 10
            ],
            [
                'quantity' => 2,
                'unitCost' => 20.50
            ],
            [
                'quantity' => 5,
                'unitCost' => 12
            ]
        ];

        $products = [];

        $products[]  = Product::create([
            'name' => 'Gold coffe',
            'profit_margin' => 25,
        ]);

        $products[] = Product::create([
            'name' => 'Arabic coffe',
            'profit_margin' => 15,
        ]);

        foreach ($products as $product) {
            foreach ($tests as $test) {
                $response = $this->actingAs($user)->post('/sales', [
                    'product' => $product->id,
                    'quantity' => $test['quantity'],
                    'unitCost' => $test['unitCost'],
                ]);

                $response
                    ->assertStatus(200);
            }
        }



        $response = $this->actingAs($user)->get('/sales/get-sales');

        $response
            ->assertStatus(200)
            ->assertJson([
                'sales' => [
                    [
                        'quantity' => 1,
                        'unit_cost' => '10.00',
                        'selling_price' => '23.34'
                    ],
                    [
                        'quantity' => 2,
                        'unit_cost' => '20.50',
                        'selling_price' => '64.67'
                    ],
                    [
                        'quantity' => 5,
                        'unit_cost' => '12.00',
                        'selling_price' => '90.00'
                    ],
                    [
                        'quantity' => 1,
                        'unit_cost' => '10.00',
                        'selling_price' => '21.77'
                    ],
                    [
                        'quantity' => 2,
                        'unit_cost' => '20.50',
                        'selling_price' => '58.24'
                    ],
                    [
                        'quantity' => 5,
                        'unit_cost' => '12.00',
                        'selling_price' => '80.59'
                    ]
                ]
            ]);
    }
}
