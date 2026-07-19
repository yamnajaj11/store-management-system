<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseReturnController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StockMovementController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => redirect()->route('dashboard'));

Route::get(
    '/dashboard',
    [DashboardController::class, 'index']
)->name('dashboard');



/*
|--------------------------------------------------------------------------
| Bulk Products
|--------------------------------------------------------------------------
*/

Route::get(
    '/products/bulk-create',
    [ProductController::class, 'bulkCreate']
)->name('products.bulkCreate');


Route::post(
    '/products/bulk-create',
    [ProductController::class, 'bulkStore']
)->name('products.bulkStore');


/*
|--------------------------------------------------------------------------
| Resources
|--------------------------------------------------------------------------
*/

Route::resource('customers', CustomerController::class);

Route::resource('products', ProductController::class);

Route::resource('sales', SaleController::class);

Route::resource('payments', PaymentController::class);

Route::resource('suppliers', SupplierController::class);

/*
|--------------------------------------------------------------------------
| Supplier Statement
|--------------------------------------------------------------------------
*/

Route::get(
    '/suppliers/{supplier}/statement',
    [SupplierController::class, 'statement']
)->name('suppliers.statement');

Route::resource('purchases', PurchaseController::class);

/*
|--------------------------------------------------------------------------
| Purchases
|--------------------------------------------------------------------------
*/

Route::get(
    '/purchases/supplier/{supplier}/products',
    [PurchaseController::class, 'supplierProducts']
)->name('purchases.supplier.products');

Route::get(
    '/purchases/{purchase}/payment',
    [PurchaseController::class, 'payment']
)->name('purchases.payment');

Route::post(
    '/purchases/{purchase}/payment',
    [PurchaseController::class, 'storePayment']
)->name('purchases.payment.store');

/*
|--------------------------------------------------------------------------
| Purchase Returns
|--------------------------------------------------------------------------
*/

Route::get(
    '/purchase-returns',
    [PurchaseReturnController::class, 'index']
)->name('purchase_returns.index');

Route::get(
    '/purchase-returns/create/{purchase}',
    [PurchaseReturnController::class, 'create']
)->name('purchase_returns.create');

Route::post(
    '/purchase-returns',
    [PurchaseReturnController::class, 'store']
)->name('purchase_returns.store');

Route::get(
    '/purchase-returns/{purchaseReturn}',
    [PurchaseReturnController::class, 'show']
)->name('purchase_returns.show');

/*
|--------------------------------------------------------------------------
| Inventory
|--------------------------------------------------------------------------
*/

Route::get(
    '/inventory',
    [InventoryController::class, 'index']
)->name('inventory.index');

/*
|--------------------------------------------------------------------------
| Exports
|--------------------------------------------------------------------------
*/

Route::get(
    '/sales/export/excel',
    [SaleController::class, 'exportExcel']
)->name('sales.exportExcel');

Route::get(
    '/payments/export/excel',
    [PaymentController::class, 'exportExcel']
)->name('payments.exportExcel');

/*
|--------------------------------------------------------------------------
| Prices
|--------------------------------------------------------------------------
*/

Route::resource('prices', PriceController::class)->only([
    'index',
    'update',
]);


Route::post(
    '/prices/bulk-update',
    [PriceController::class, 'bulkUpdate']
)->name('prices.bulkUpdate');







Route::get(
    '/stock-movements',
    [StockMovementController::class,'index']
)
->name('stock_movements.index');


Route::get(
    '/stock-movements/{id}',
    [StockMovementController::class,'show']
)
->name('stock_movements.show');