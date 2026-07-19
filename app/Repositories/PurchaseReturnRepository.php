<?php

namespace App\Repositories;

use App\Interfaces\PurchaseReturnRepositoryInterface;
use App\Models\Purchase;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnItem;
use App\Services\StockService;
use Illuminate\Support\Facades\DB;

class PurchaseReturnRepository implements PurchaseReturnRepositoryInterface
{

    public function __construct(
        protected StockService $stockService
    ) {
    }



    public function all()
    {
        return PurchaseReturn::with([
            'purchase',
            'supplier',
            'items.product',

        ])
            ->latest()
            ->get();
    }





    public function find($id)
    {
        return PurchaseReturn::with([
            'purchase',
            'supplier',
            'items.product',
        ])
            ->findOrFail($id);
    }





    public function create(array $data)
    {

        return DB::transaction(function () use ($data) {

            $purchase = Purchase::with([
                'supplier',
                'items.product',
            ])
                ->findOrFail($data['purchase_id']);



            $totalAmount = 0;



            foreach ($data['items'] as $item) {


                $quantity = (int) $item['quantity'];


                if ($quantity <= 0) {
                    continue;
                }



                $purchaseItem =
                    $purchase->items()
                        ->findOrFail(
                            $item['purchase_item_id']
                        );



                if ($quantity > $purchaseItem->available_quantity) {

                    throw new \Exception(
                        'الكمية المرتجعة أكبر من الكمية المتاحة.'
                    );
                }



                $totalAmount +=
                    $quantity *
                    $purchaseItem->price;
            }




            $purchaseReturn = PurchaseReturn::create([
                'return_number' => $this->generateReturnNumber(),

                'invoice_number' => $this->generateReturnNumber(),
                'purchase_id' => $purchase->id,

                'supplier_id' => $purchase->supplier_id,

                'total_amount' => $totalAmount,

                'return_date' => $data['return_date'],

                'note' => $data['note'] ?? null,

            ]);




            foreach ($data['items'] as $item) {


                $quantity = (int) $item['quantity'];


                if ($quantity <= 0) {
                    continue;
                }



                $purchaseItem =
                    $purchase->items()
                        ->findOrFail(
                            $item['purchase_item_id']
                        );



                $subtotal =
                    $quantity *
                    $purchaseItem->price;



                PurchaseReturnItem::create([

                    'purchase_return_id'
                    => $purchaseReturn->id,

                    'purchase_item_id'
                    => $purchaseItem->id,

                    'product_id'
                    => $purchaseItem->product_id,

                    'quantity'
                    => $quantity,

                    'price'
                    => $purchaseItem->price,

                    'subtotal'
                    => $subtotal,

                ]);





                $purchaseItem->increment(
                    'returned_quantity',
                    $quantity
                );





                $this->stockService->decrease(

                    $purchaseItem->product,

                    $quantity,

                    'purchase_return',

                    $purchaseReturn,

                    'مرتجع شراء رقم ' . $purchaseReturn->id

                );
            }



            return $purchaseReturn;
        });
    }

    private function generateReturnNumber(): string
    {
        $lastId = PurchaseReturn::max('id') + 1;

        return 'RET-' . str_pad(
            $lastId,
            6,
            '0',
            STR_PAD_LEFT
        );
    }
}
