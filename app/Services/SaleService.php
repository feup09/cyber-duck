<?php

namespace App\Services;

class SaleService
{
    const PROFIT_MARGIN = 0.25;
    const SHIPPING_COST = 10;

    private function calculateCost($quantity = 0, $unitCost = 0)
    {
        return $quantity * $unitCost;
    }
    public function calculateSellingPrice($quantity = 0, $unitCost = 0)
    {
        return ceil((($this->calculateCost($quantity, $unitCost) / (1 - self::PROFIT_MARGIN)) + self::SHIPPING_COST) * 100) / 100;
    }
}
