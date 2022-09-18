<?php

namespace App\Http\Controllers;

use App\Services\SaleService;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    protected $saleService;

    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
    }

    public function calculateSellingPrice(Request $request)
    {
        $request->validate([
            'quantity' => 'required|gt:0',
            'unitCost' => 'required|gt:0',
        ]);

        return response()->json([
            'sellingPrice' => $this->saleService->calculateSellingPrice($request->input('quantity'), $request->input('unitCost'))
        ]);
    }
}
