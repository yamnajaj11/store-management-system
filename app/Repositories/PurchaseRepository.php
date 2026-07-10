<?php

namespace App\Repositories;

use App\Models\Purchase;
use App\Interfaces\PurchaseRepositoryInterface;

class PurchaseRepository implements PurchaseRepositoryInterface
{
    public function all()
    {
        return Purchase::with(['product', 'supplier'])->latest()->get();
    }

    public function find($id)
    {
        return Purchase::with(['product', 'supplier'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Purchase::create($data);
    }

    public function update($id, array $data)
    {
        $purchase = $this->find($id);
        $purchase->update($data);
        return $purchase;
    }

    public function delete($id)
    {
        $purchase = $this->find($id);
        return $purchase->delete();
    }
}
