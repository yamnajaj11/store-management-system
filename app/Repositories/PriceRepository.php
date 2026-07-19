<?php

namespace App\Repositories;

use App\Interfaces\PriceRepositoryInterface;
use App\Models\Product;

class PriceRepository implements PriceRepositoryInterface
{
    public function all()
    {
        return Product::orderBy('name')->get();
    }

    public function find($id)
    {
        return Product::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $product = $this->find($id);

        $product->update([
            'purchase_price' => $data['purchase_price'],
            'selling_price' => $data['selling_price'],
        ]);

        return $product;
    }
}
