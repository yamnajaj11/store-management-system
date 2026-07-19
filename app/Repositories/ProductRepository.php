<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAll(?string $search = null, int $perPage = 10): LengthAwarePaginator
    {
        $query = Product::with('suppliers');

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        return $query
            ->orderByDesc('id')
            ->paginate($perPage);
    }

    public function getById(int $id): Product
    {
        return Product::with('suppliers')->findOrFail($id);
    }

    public function create(array $data): Product
    {
        $data['product_number'] = $this->generateProductNumber();

        return Product::create($data);
    }

    public function update(int $id, array $data): ?Product
    {
        $product = Product::find($id);

        if ($product) {
            $product->update($data);

            return $product;
        }

        return null;
    }

    public function delete(int $id): bool
    {
        $product = Product::find($id);

        if ($product) {
            return (bool) $product->delete();
        }

        return false;
    }
    private function generateProductNumber(): string
    {
        $lastId = Product::max('id') + 1;


        return 'PRD-' .
            str_pad(
                $lastId,
                6,
                '0',
                STR_PAD_LEFT
            );
    }
}
