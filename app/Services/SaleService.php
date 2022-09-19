<?php

namespace App\Services;

use App\Models\Product;

class SaleService
{
    const SHIPPING_COST = 10;

    private function calculateCost($quantity = 0, $unitCost = 0)
    {
        return $quantity * $unitCost;
    }
    private function profitMargin($product)
    {
        return Product::find($product)->profit_margin / 100;
    }
    public function calculateSellingPrice($product = 0, $quantity = 0, $unitCost = 0)
    {
        return ceil((($this->calculateCost($quantity, $unitCost) / (1 - $this->profitMargin($product))) + self::SHIPPING_COST) * 100) / 100;
    }
}
