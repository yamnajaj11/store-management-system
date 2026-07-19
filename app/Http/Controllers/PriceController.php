<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    public function index(Request $request)
    {

        $products = Product::with([
            'purchaseItems',
        ])
            ->when($request->search, function ($q) use ($request) {

                $q->where(
                    'name',
                    'like',
                    '%' . $request->search . '%'
                );

            })
            ->orderBy('name')
            ->paginate(20);



        foreach ($products as $product) {


            $product->last_purchase_price =
                $product->purchaseItems()
                    ->latest()
                    ->value('price') ?? 0;



            $totalQuantity =
                $product->purchaseItems()
                    ->sum('quantity');



            $totalAmount =
                $product->purchaseItems()
                    ->sum('subtotal');



            $product->average_cost =
                $totalQuantity > 0
                ?
                $totalAmount / $totalQuantity
                :
                0;



            $product->profit =
                $product->selling_price -
                $product->average_cost;



            $product->profit_percentage =
                $product->average_cost > 0
                ?
                ($product->profit / $product->average_cost) * 100
                :
                0;

        }



        // كل المنتجات للتسعير الجماعي
        $allProducts = Product::orderBy('name')->get();



        return view('prices.index', compact(
            'products',
            'allProducts'
        ));

    }




    public function update(Request $request, Product $price)
    {

        $validated = $request->validate([

            'purchase_price' =>
                'required|numeric|min:0',

            'selling_price' =>
                'required|numeric|min:0',

        ]);



        $price->update($validated);



        return back()
            ->with(
                'success',
                __('prices.updated')
            );

    }





    public function bulkUpdate(Request $request)
    {


        $request->validate([

            'prices' => 'required|array',

        ]);




        foreach ($request->prices as $id => $sellingPrice) {



            if ($sellingPrice !== null && $sellingPrice !== '') {


                Product::where('id', $id)
                    ->update([

                        'selling_price' =>
                            $sellingPrice

                    ]);

            }


        }




        return back()
            ->with(
                'success',
                __('prices.updated')
            );


    }
}