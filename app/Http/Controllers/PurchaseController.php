<?php

namespace App\Http\Controllers;

use App\Interfaces\PurchaseRepositoryInterface;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    protected $purchaseRepo;

    public function __construct(PurchaseRepositoryInterface $purchaseRepo)
    {
        $this->purchaseRepo = $purchaseRepo;
    }

    public function index()
    {
        $purchases = $this->purchaseRepo->all();
        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $products = Product::all();
        $suppliers = Supplier::all();
        return view('purchases.create', compact('products', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id'   => 'required|exists:products,id',
            'supplier_id'  => 'required|exists:suppliers,id',
            'quantity'     => 'required|integer|min:1',
            'price'        => 'required|numeric|min:0',
            'purchased_at' => 'required|date',
        ]);

        $this->purchaseRepo->create($validated);

        return redirect()->route('purchases.index')->with('success', 'تمت إضافة عملية الشراء بنجاح.');
    }

    public function edit($id)
    {
        $purchase = $this->purchaseRepo->find($id);
        $products = Product::all();
        $suppliers = Supplier::all();

        return view('purchases.edit', compact('purchase', 'products', 'suppliers'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'product_id'   => 'required|exists:products,id',
            'supplier_id'  => 'required|exists:suppliers,id',
            'quantity'     => 'required|integer|min:1',
            'price'        => 'required|numeric|min:0',
            'purchased_at' => 'required|date',
        ]);

        $this->purchaseRepo->update($id, $validated);

        return redirect()->route('purchases.index')->with('success', 'تم تعديل عملية الشراء بنجاح.');
    }

    public function destroy($id)
    {
        $this->purchaseRepo->delete($id);
        return redirect()->route('purchases.index')->with('success', 'تم حذف العملية.');
    }
}
