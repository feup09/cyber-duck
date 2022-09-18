<?php

use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::redirect('/dashboard', '/sales');

Route::get('/shipping-partners', function () {
    return view('shipping_partners');
})->middleware(['auth'])->name('shipping.partners');


Route::prefix('sales')->middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('coffee_sales');
    })->name('coffee.sales');
    Route::post('/', [SaleController::class, 'store'])->name('coffe.sales.store-sale');
    Route::get('/get-selling-price', [SaleController::class, 'calculateSellingPrice'])->name('coffe.sales.get-selling-price');
    Route::get('/get-sales', [SaleController::class, 'getSales'])->name('coffe.sales.get-sales');
});


require __DIR__ . '/auth.php';
