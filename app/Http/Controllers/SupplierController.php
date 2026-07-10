<?php

namespace App\Http\Controllers;

use App\Interfaces\SupplierRepositoryInterface;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    protected SupplierRepositoryInterface $supplierRepo;

    public function __construct(SupplierRepositoryInterface $supplierRepo)
    {
        $this->supplierRepo = $supplierRepo;
    }

    public function index()
    {
        $suppliers = $this->supplierRepo->all();

        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $this->supplierRepo->create($validated);

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'تمت إضافة المورد بنجاح.');
    }

    public function edit(int $id)
    {
        $supplier = $this->supplierRepo->find($id);

        if (!$supplier) {
            return redirect()
                ->route('suppliers.index')
                ->withErrors('المورد غير موجود.');
        }

        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $updated = $this->supplierRepo->update($id, $validated);

        if (!$updated) {
            return redirect()
                ->back()
                ->withErrors('تعذر تعديل المورد.');
        }

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'تم تعديل المورد بنجاح.');
    }

    public function show(int $id)
    {
        $supplier = $this->supplierRepo->find($id);

        if (!$supplier) {
            return redirect()
                ->route('suppliers.index')
                ->withErrors('المورد غير موجود.');
        }

        return view('suppliers.show', compact('supplier'));
    }

    public function destroy(int $id)
    {
        $deleted = $this->supplierRepo->delete($id);

        if (!$deleted) {
            return redirect()
                ->back()
                ->withErrors('تعذر حذف المورد.');
        }

        return redirect()
            ->route('suppliers.index')
            ->with('success', 'تم حذف المورد بنجاح.');
    }
}