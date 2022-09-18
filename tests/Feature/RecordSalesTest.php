<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class RecordSalesTest extends TestCase
{

    public function test_record_sales()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/sales', [
            'quantity' => 1,
            'unitCost' => 10,
        ]);

        $response
            ->assertStatus(200);

        $response = $this->actingAs($user)->post('/sales', [
            'quantity' => 2,
            'unitCost' => 20.50,
        ]);

        $response
            ->assertStatus(200);

        $response = $this->actingAs($user)->post('/sales', [
            'quantity' => 5,
            'unitCost' => 12,
        ]);

        $response
            ->assertStatus(200);


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
                    ]
                ]
            ]);
    }
}
