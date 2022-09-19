<?php

namespace App\Http\Controllers;

use App\Models\Product;
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

    public function index()
    {
        $products = Product::all('id', 'name', 'profit_margin');

        return view('coffee_sales', compact('products'));
    }

    public function calculateSellingPrice(Request $request)
    {
        $request->validate([
            'product' => 'required|exists:products,id',
            'quantity' => 'required|gt:0',
            'unitCost' => 'required|gt:0',
        ]);

        return response()->json([
            'sellingPrice' => $this->saleService->calculateSellingPrice($request->input('product'), $request->input('quantity'), $request->input('unitCost'))
        ]);
    }

    public function getSales()
    {
        return response()->json([
            'sales' => Sale::with('product:id,name')->get(['quantity', 'unit_cost', 'selling_price','product_id'])
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'product' => 'required|exists:products,id',
            'quantity' => 'required|gt:0',
            'unitCost' => 'required|gt:0',
        ]);

        Sale::create([
            'product_id' => $request->product,
            'quantity' => $request->quantity,
            'unit_cost' => $request->unitCost,
            'selling_price' => $this->saleService->calculateSellingPrice($request->product, $request->quantity, $request->unitCost)
        ]);
    }
}
