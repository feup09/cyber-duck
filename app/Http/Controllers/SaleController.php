<?php

namespace App\Http\Controllers;

use App\Models\Sale;
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

    public function getSales()
    {
        return response()->json([
            'sales' => Sale::all('quantity', 'unit_cost', 'selling_price')
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'quantity' => 'required|gt:0',
            'unitCost' => 'required|gt:0',
        ]);

        Sale::create([
            'quantity' => $request->quantity,
            'unit_cost' => $request->unitCost,
            'selling_price' => $this->saleService->calculateSellingPrice($request->quantity, $request->unitCost)
        ]);
    }
}
