<?php

namespace App\Http\Controllers;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

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
        $suppliers = Supplier::orderBy('name')->get();

        return view('products.create', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([

            'name' => 'required|string|max:255|unique:products,name',

            'unit' => 'required|string|max:50',

            'supplier_id' => 'required|exists:suppliers,id',

            'description' => 'nullable|string|max:1000',

        ]);


        $supplierId = $data['supplier_id'];

        unset($data['supplier_id']);


        $data['stock'] = 0;

        $data['purchase_price'] = 0;

        $data['selling_price'] = 0;



        $product = $this->productRepo->create($data);



        $product->suppliers()->sync([

            $supplierId

        ]);



        return redirect()

            ->route('products.index')

            ->with('success', 'تم إنشاء المنتج بنجاح.');
    }

    public function edit(int $id)
    {
        try {
            $product = $this->productRepo->getById($id);

            $suppliers = Supplier::orderBy('name')->get();

            return view('products.edit', compact(
                'product',
                'suppliers'
            ));
        } catch (ModelNotFoundException $e) {
            return redirect()
                ->route('products.index')
                ->withErrors('المنتج غير موجود');
        }
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([

            'name' => "required|string|max:255|unique:products,name,{$id}",

            'unit' => 'required|string|max:50',

            'supplier_ids' => 'nullable|array',

            'supplier_ids.*' => 'exists:suppliers,id',

            'description' => 'nullable|string|max:1000',

            'selling_price' => 'nullable|numeric|min:0',

        ]);



        $supplierIds = $data['supplier_ids'] ?? [];

        unset($data['supplier_ids']);



        $updated = $this->productRepo->update($id, $data);



        if (!$updated) {

            return back()
                ->withErrors('تعذر تحديث المنتج.');

        }



        $product = Product::find($id);



        $product->suppliers()->sync($supplierIds);



        return redirect()
            ->route('products.index')
            ->with('success', 'تم تحديث المنتج بنجاح.');
    }

    public function bulkCreate()
    {
        $suppliers = Supplier::orderBy('name')->get();

        return view('products.bulk_create', compact('suppliers'));
    }


    public function bulkStore(Request $request)
    {
        $data = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',

            'products' => 'required|array|min:1',

            'products.*.name' => 'required|string|max:255',

            'products.*.unit' => 'required|string|max:50',

            'products.*.description' => 'nullable|string|max:1000',
        ]);


        $supplierId = $data['supplier_id'];


        foreach ($data['products'] as $item) {


            $product = $this->productRepo->create([

                'name' => $item['name'],

                'unit' => $item['unit'],

                'description' => $item['description'] ?? null,

                'stock' => 0,

                'purchase_price' => 0,

                'selling_price' => 0,

            ]);


            $product->suppliers()->sync([

                $supplierId

            ]);

        }


        return redirect()

            ->route('products.index')

            ->with('success', 'تم إضافة المنتجات وربطها بالمورد بنجاح.');
    }

    public function destroy(int $id)
    {
        $deleted = $this->productRepo->delete($id);

        if (!$deleted) {
            return back()
                ->withErrors('تعذر حذف المنتج.');
        }

        return redirect()
            ->route('products.index')
            ->with('success', 'تم حذف المنتج بنجاح.');
    }
}
