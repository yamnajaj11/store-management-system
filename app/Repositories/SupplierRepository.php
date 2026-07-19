<?php

namespace App\Repositories;

use App\Models\Supplier;
use App\Interfaces\SupplierRepositoryInterface;

class SupplierRepository implements SupplierRepositoryInterface
{


    public function all()
    {
        return Supplier::with([
            'purchases.items',
            'purchases.payments',
            'purchases.returns',
        ])
            ->latest()
            ->get();
    }




    public function find($id)
    {
        return Supplier::with([

            'purchases.items',

            'purchases.payments',

            'purchases.returns.items',

            'products',

        ])
            ->findOrFail($id);
    }





    private function generateSupplierNumber()
    {

        $last = Supplier::latest('id')->first();


        $number = $last
            ? $last->id + 1
            : 1;


        return 'SUP-' .
            str_pad(
                $number,
                6,
                '0',
                STR_PAD_LEFT
            );

    }





    public function create(array $data)
    {

        $data['supplier_number'] =
            $this->generateSupplierNumber();


        $data['opening_balance'] =
            $data['opening_balance'] ?? 0;


        $data['note'] =
            $data['note'] ?? null;


        return Supplier::create($data);

    }




    public function update($id, array $data)
    {

        $supplier = $this->find($id);


        $supplier->update($data);


        return $supplier;

    }





    public function delete($id)
    {

        $supplier = $this->find($id);


        return $supplier->delete();

    }





    /*
    |--------------------------------------------------------------------------
    | كشف حساب المورد
    |--------------------------------------------------------------------------
    */

    public function statement($id)
    {

        return Supplier::with([

            'purchases.items',

            'purchases.payments',

            'purchases.returns.items',

        ])
            ->findOrFail($id);

    }


}