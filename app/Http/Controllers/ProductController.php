<?php

namespace App\Http\Controllers;

use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductController extends Controller
{
    protected ProductRepositoryInterface $productRepo;

    public function __construct(ProductRepositoryInterface $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $products = $this->productRepo->getAll($search, 10);

        return view('products.index', compact('products'));
    }

    public function show(int $id)
    {
        try {
            $product = $this->productRepo->getById($id);

            return view('products.show', compact('product'));
        } catch (ModelNotFoundException $e) {
            return redirect()
                ->route('products.index')
                ->withErrors('المنتج غير موجود');
        }
    }

    public function create()
    {
        $suppliers = \App\Models\Supplier::all();

        return view('products.create', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255|unique:products,name',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price'  => 'required|numeric|min:0',
            'stock'          => 'required|integer|min:0',
            'unit'           => 'required|string|max:50',
            'barcode'        => 'nullable|string|max:255',
            'supplier_id'    => 'nullable|exists:suppliers,id',
            'description'    => 'nullable|string|max:1000',
        ]);

        $this->productRepo->create($data);

        return redirect()
            ->route('products.index')
            ->with('success', 'تم إنشاء المنتج بنجاح.');
    }

    public function edit(int $id)
    {
        try {
            $product = $this->productRepo->getById($id);
            $suppliers = \App\Models\Supplier::all();

            return view('products.edit', compact('product', 'suppliers'));
        } catch (ModelNotFoundException $e) {
            return redirect()
                ->route('products.index')
                ->withErrors('المنتج غير موجود');
        }
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'name'           => "required|string|max:255|unique:products,name,{$id}",
            'purchase_price' => 'required|numeric|min:0',
            'selling_price'  => 'required|numeric|min:0',
            'stock'          => 'required|integer|min:0',
            'unit'           => 'required|string|max:50',
            'barcode'        => 'nullable|string|max:255',
            'supplier_id'    => 'nullable|exists:suppliers,id',
            'description'    => 'nullable|string|max:1000',
        ]);

        $updated = $this->productRepo->update($id, $data);

        if (!$updated) {
            return redirect()
                ->back()
                ->withErrors('تعذر تحديث المنتج.');
        }

        return redirect()
            ->route('products.index')
            ->with('success', 'تم تحديث المنتج بنجاح.');
    }

    public function destroy(int $id)
    {
        $deleted = $this->productRepo->delete($id);

        if (!$deleted) {
            return redirect()
                ->back()
                ->withErrors('تعذر حذف المنتج أو المنتج غير موجود.');
        }

        return redirect()
            ->route('products.index')
            ->with('success', 'تم حذف المنتج بنجاح.');
    }
}