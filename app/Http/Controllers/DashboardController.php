<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Payment;
use App\Models\Purchase;
use App\Models\PurchasePayment;
use App\Models\StockMovement;


class DashboardController extends Controller
{

    public function index()
    {

        $stats = [

            // الأساسي
            'customers' =>
                Customer::count(),


            'suppliers' =>
                Supplier::count(),


            'products' =>
                Product::count(),



            // المبيعات
            'sales' =>
                Sale::sum('final_amount'),



            // المشتريات
            'purchases' =>
                Purchase::sum('total_amount'),



            // المقبوضات من الزبائن
            'payments' =>
                Payment::sum('amount'),



            // المدفوع للموردين
            'purchase_payments' =>
                PurchasePayment::sum('amount'),




            // ديون العملاء
            'customer_debt' =>

                Sale::sum('final_amount')
                -
                Payment::sum('amount'),




            // ديون الموردين
            'supplier_debt' =>

                Purchase::sum('total_amount')
                -
                PurchasePayment::sum('amount'),





            // منتجات تحتاج انتباه
            'low_stock' =>

                Product::where('stock', '<=', 5)
                    ->count(),

        ];





        $latestSales = Sale::with('customer')
            ->latest()
            ->limit(5)
            ->get();





        $latestPurchases = Purchase::with('supplier')
            ->latest()
            ->limit(5)
            ->get();





        $latestMovements = StockMovement::with('product')
            ->latest()
            ->limit(5)
            ->get();





        return view(
            'dashboard.index',
            compact(
                'stats',
                'latestSales',
                'latestPurchases',
                'latestMovements'
            )
        );

    }

}