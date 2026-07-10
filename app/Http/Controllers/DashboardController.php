<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'customers' => Customer::count(),
            'suppliers' => Supplier::count(),
            'products' => Product::count(),
            'sales' => Sale::sum('total_amount'),
            'payments' => Payment::sum('amount'),
        ];

        return view('dashboard.index', compact('stats'));
    }
}
