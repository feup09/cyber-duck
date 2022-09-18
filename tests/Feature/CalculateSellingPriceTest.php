<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CalculateSellingPriceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_sales_screen_can_be_rendered()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/sales');

        $response->assertStatus(200);
    }
    public function test_user_can_calculate_selling_price()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/sales/get-selling-price?quantity=1&unitCost=10');

        $response
            ->assertStatus(200)
            ->assertJson([
                'sellingPrice' => 23.34
            ]);

        $response = $this->actingAs($user)->get('/sales/get-selling-price?quantity=2&unitCost=20.50');

        $response
            ->assertStatus(200)
            ->assertJson([
                'sellingPrice' => 64.67
            ]);

        $response = $this->actingAs($user)->get('/sales/get-selling-price?quantity=5&unitCost=12');

        $response
            ->assertStatus(200)
            ->assertJson([
                'sellingPrice' => 90.00
            ]);
    }
}
