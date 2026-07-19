<?php

namespace App\Http\Controllers;

use App\Interfaces\PurchaseRepositoryInterface;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function __construct(
        protected PurchaseRepositoryInterface $purchaseRepo
    ) {
    }


    public function index()
    {
        $purchases = $this->purchaseRepo->all();

        return view('purchases.index', compact('purchases'));
    }



    public function create()
    {
        $suppliers = Supplier::orderBy('name')->get();

        return view('purchases.create', compact('suppliers'));
    }




    public function supplierProducts($supplierId)
    {
        $products = Supplier::findOrFail($supplierId)
            ->products()
            ->orderBy('name')
            ->get([
                'products.id',
                'products.name',
            ]);

        return response()->json($products);
    }





    public function store(Request $request)
    {
        $data = $this->validatePurchase($request, true);


        $this->purchaseRepo->create($data);


        return redirect()
            ->route('purchases.index')
            ->with('success', 'تمت إضافة عملية الشراء بنجاح.');
    }





    public function show($id)
    {
        $purchase = $this->purchaseRepo->find($id);


        return view('purchases.show', compact('purchase'));
    }






    public function edit($id)
    {
        $purchase = $this->purchaseRepo->find($id);


        $suppliers = Supplier::orderBy('name')->get();


        $products = $purchase->supplier->products;


        return view('purchases.edit', compact(
            'purchase',
            'suppliers',
            'products'
        ));
    }






    public function update(Request $request, $id)
    {
        $purchase = $this->purchaseRepo->find($id);


        $data = $this->validatePurchase($request);



        if ($purchase->paid_amount >= $purchase->total_amount) {


            foreach ($purchase->items as $oldItem) {


                $newItem = collect($data['items'])
                    ->where('product_id', $oldItem->product_id)
                    ->first();



                if (
                    !$newItem ||
                    $newItem['quantity'] < $oldItem->quantity ||
                    $newItem['price'] != $oldItem->price
                ) {


                    return back()
                        ->withInput()
                        ->with(
                            'error',
                            'الفاتورة مدفوعة بالكامل، لا يمكن التخفيض. استخدم المرتجع.'
                        );

                }


            }

        }



        $this->purchaseRepo->update($id, $data);



        return redirect()
            ->route('purchases.index')
            ->with('success', 'تم تعديل عملية الشراء بنجاح.');
    }







    public function destroy($id)
    {
        $this->purchaseRepo->delete($id);


        return redirect()
            ->route('purchases.index')
            ->with('success', 'تم حذف عملية الشراء بنجاح.');
    }






    public function payment($id)
    {
        $purchase = $this->purchaseRepo->find($id);


        return view('purchases.payment', compact('purchase'));
    }







    public function storePayment(Request $request, $id)
    {
        $data = $request->validate([

            'amount' => 'required|numeric|min:0.01',

        ]);



        $this->purchaseRepo->addPayment(
            $id,
            $data['amount']
        );



        return redirect()
            ->route('purchases.index')
            ->with('success', 'تم إضافة الدفعة بنجاح.');
    }







    private function validatePurchase(Request $request, bool $withPayment = false)
    {

        $rules = [

            'supplier_id' => 'required|exists:suppliers,id',

            'purchase_date' => 'required|date',


            'items' => 'required|array|min:1',


            'items.*.product_id' => 'required|exists:products,id',


            'items.*.quantity' => 'required|integer|min:1',


            'items.*.price' => 'required|numeric|min:0',



        ];



        if ($withPayment) {

            $rules['paid_amount'] =
                'nullable|numeric|min:0';

        }



        return $request->validate($rules);

    }

}