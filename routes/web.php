<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    CustomerController,
    ProductController,
    SaleController,
    PaymentController,
    SupplierController,
    PurchaseController
};

Route::get('/', fn() => redirect()->route('dashboard'));

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('customers', CustomerController::class);
Route::resource('products', ProductController::class);
Route::resource('sales', SaleController::class);
Route::resource('payments', PaymentController::class);
Route::resource('suppliers', SupplierController::class);
Route::resource('purchases', PurchaseController::class);


Route::get('/sales/export/excel', [SaleController::class, 'exportExcel'])->name('sales.exportExcel');

Route::get('payments/export/excel', [PaymentController::class, 'exportExcel'])->name('payments.exportExcel');

