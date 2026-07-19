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

            'name' => 'required|string|max:255',

            'company' => 'nullable|string|max:255',

            'phone' => 'nullable|string|max:20',

            'address' => 'nullable|string|max:500',

            'opening_balance' => 'nullable|numeric',

            'note' => 'nullable|string',

        ]);


        $this->supplierRepo->create($validated);



        return redirect()
            ->route('suppliers.index')
            ->with('success', 'تمت إضافة المورد بنجاح.');
    }





    public function edit(int $id)
    {

        $supplier = $this->supplierRepo->find($id);


        return view(
            'suppliers.edit',
            compact('supplier')
        );

    }





    public function update(Request $request, int $id)
    {

        $validated = $request->validate([

            'name' => 'required|string|max:255',

            'company' => 'nullable|string|max:255',

            'phone' => 'nullable|string|max:20',

            'address' => 'nullable|string|max:500',

            'opening_balance' => 'nullable|numeric',

            'note' => 'nullable|string',

        ]);



        $this->supplierRepo->update(
            $id,
            $validated
        );



        return redirect()
            ->route('suppliers.index')
            ->with('success', 'تم تعديل المورد بنجاح.');

    }





    public function show(int $id)
    {

        $supplier = $this->supplierRepo->find($id);


        return view(
            'suppliers.show',
            compact('supplier')
        );

    }



    public function statement(int $id)
    {

        $supplier = $this->supplierRepo->statement($id);


        return view(
            'suppliers.statement',
            compact('supplier')
        );

    }

    public function destroy(int $id)
    {

        $this->supplierRepo->delete($id);


        return redirect()
            ->route('suppliers.index')
            ->with('success', 'تم حذف المورد بنجاح.');

    }

}