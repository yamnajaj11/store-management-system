<?php

namespace App\Repositories;

use App\Models\Supplier;
use App\Interfaces\SupplierRepositoryInterface;

class SupplierRepository implements SupplierRepositoryInterface
{
    public function all()
    {
        return Supplier::with('purchases')->latest()->get();
    }

    public function find($id)
    {
        return Supplier::with('purchases')->findOrFail($id);
    }

    public function create(array $data)
    {
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
}
