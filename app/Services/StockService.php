<?php

namespace App\Services;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Database\Eloquent\Model;
use Exception;


class StockService
{


    /**
     * زيادة المخزون
     */
    public function increase(
        Product $product,
        int $quantity,
        string $type,
        ?Model $reference = null,
        ?string $note = null
    ) {


        $product->increment(
            'stock',
            $quantity
        );


        $product->refresh();



        return StockMovement::create([

            'product_id' => $product->id,

            'type' => $type,

            'quantity' => $quantity,

            'stock_after' => $product->stock,

            'reference_type' =>
                $reference
                ? get_class($reference)
                : null,

            'reference_id' =>
                $reference?->id,

            'note' => $note,

        ]);


    }






    /**
     * نقصان المخزون
     */
    public function decrease(
        Product $product,
        int $quantity,
        string $type,
        ?Model $reference = null,
        ?string $note = null
    ) {


        if ($product->stock < $quantity) {


            throw new Exception(
                "المخزون غير كافي للمنتج: {$product->name}"
            );


        }




        $product->decrement(
            'stock',
            $quantity
        );


        $product->refresh();




        return StockMovement::create([

            'product_id' => $product->id,

            'type' => $type,

            'quantity' => -$quantity,

            'stock_after' => $product->stock,

            'reference_type' =>
                $reference
                ? get_class($reference)
                : null,

            'reference_id' =>
                $reference?->id,

            'note' => $note,

        ]);

    }






    /**
     * تعديل مباشر للمخزون
     */
    public function adjust(
        Product $product,
        int $quantity,
        string $type,
        ?Model $reference = null,
        ?string $note = null
    ) {


        $oldStock = $product->stock;



        $product->update([

            'stock' => $quantity,

        ]);




        return StockMovement::create([

            'product_id' => $product->id,

            'type' => $type,

            'quantity' =>
                $quantity - $oldStock,

            'stock_after' =>
                $product->stock,

            'reference_type' =>
                $reference
                ? get_class($reference)
                : null,

            'reference_id' =>
                $reference?->id,

            'note' => $note,

        ]);

    }


}