<?php

namespace App\Repositories;

use App\Interfaces\InventoryRepositoryInterface;
use App\Models\Product;

class InventoryRepository implements InventoryRepositoryInterface
{
    public function all()
    {
        return Product::with('suppliers')
            ->latest()
            ->get();
    }

    public function search($search = null)
    {
        return Product::with('suppliers')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('barcode', 'like', "%{$search}%");
            })
            ->latest()
            ->get();
    }
}
