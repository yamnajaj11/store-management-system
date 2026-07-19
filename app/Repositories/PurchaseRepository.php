<?php

namespace App\Repositories;

use App\Interfaces\PurchaseRepositoryInterface;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchasePayment;
use App\Services\StockService;
use Illuminate\Support\Facades\DB;

class PurchaseRepository implements PurchaseRepositoryInterface
{
    public function __construct(
        protected StockService $stockService
    ) {
    }


    public function all()
    {
        return Purchase::with([
            'supplier',
            'items.product',
            'payments'
        ])
            ->latest()
            ->get();
    }



    public function find($id)
    {
        return Purchase::with([
            'supplier',
            'items.product',
            'payments',
            'returns.items.product'
        ])
            ->findOrFail($id);
    }



    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {

            $purchase = Purchase::create([

                'invoice_number' => $this->generateInvoiceNumber(),

                'supplier_id' => $data['supplier_id'],

                'purchase_date' => $data['purchase_date'],

                'total_amount' => 0,

                'status' => 'غير مدفوع',

            ]);



            $total = 0;



            foreach ($data['items'] as $item) {


                $subtotal =
                    $item['quantity'] * $item['price'];



                $purchase->items()->create([

                    'product_id' => $item['product_id'],

                    'quantity' => $item['quantity'],

                    'price' => $item['price'],

                    'subtotal' => $subtotal,

                ]);



                $product = Product::findOrFail(
                    $item['product_id']
                );



                // زيادة المخزون
                $this->stockService->increase(

                    $product,

                    $item['quantity'],

                    'purchase',

                    $purchase,

                    'شراء فاتورة رقم ' . $purchase->invoice_number

                );



                // تحديث سعر الشراء فقط
                $product->update([

                    'purchase_price' => $item['price'],

                ]);



                // ربط المورد بالمنتج
                $product->suppliers()
                    ->syncWithoutDetaching([

                        $data['supplier_id']

                    ]);



                $total += $subtotal;

            }




            $purchase->update([

                'total_amount' => $total,

            ]);





            if (!empty($data['paid_amount']) && $data['paid_amount'] > 0) {


                PurchasePayment::create([

                    'purchase_id' => $purchase->id,

                    'amount' => $data['paid_amount'],

                    'payment_date' => now(),

                ]);

            }





            $purchase->update([

                'status' => $this->paymentStatus(

                    $purchase->fresh()->paid_amount,

                    $total

                ),

            ]);




            return $purchase;

        });
    }






    public function update($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {


            $purchase = $this->find($id);



            // إرجاع الكميات القديمة من المخزون
            foreach ($purchase->items as $item) {


                $product = Product::findOrFail(
                    $item->product_id
                );


                $this->stockService->decrease(

                    $product,

                    $item->quantity,

                    'purchase_update',

                    $purchase,

                    'إلغاء كمية تعديل فاتورة شراء رقم ' . $purchase->invoice_number

                );

            }




            $purchase->items()->delete();




            $purchase->update([

                'supplier_id' => $data['supplier_id'],

                'purchase_date' => $data['purchase_date'],

            ]);




            $total = 0;




            foreach ($data['items'] as $item) {


                $subtotal =
                    $item['quantity'] * $item['price'];



                $purchase->items()->create([

                    'product_id' => $item['product_id'],

                    'quantity' => $item['quantity'],

                    'price' => $item['price'],

                    'subtotal' => $subtotal,

                ]);




                $product = Product::findOrFail(
                    $item['product_id']
                );




                $this->stockService->increase(

                    $product,

                    $item['quantity'],

                    'purchase_update',

                    $purchase,

                    'تعديل فاتورة شراء رقم ' . $purchase->invoice_number

                );




                // تحديث سعر الشراء فقط
                $product->update([

                    'purchase_price' => $item['price'],

                ]);




                $total += $subtotal;

            }





            $purchase->update([

                'total_amount' => $total,

                'status' => $this->paymentStatus(

                    $purchase->fresh()->paid_amount,

                    $total

                ),

            ]);




            return $purchase;

        });
    }







    public function delete($id)
    {
        return DB::transaction(function () use ($id) {


            $purchase = $this->find($id);



            foreach ($purchase->items as $item) {


                $product = Product::findOrFail(
                    $item->product_id
                );



                $this->stockService->decrease(

                    $product,

                    $item->quantity,

                    'purchase_delete',

                    $purchase,

                    'حذف فاتورة شراء رقم ' . $purchase->invoice_number

                );

            }



            return $purchase->delete();

        });
    }







    public function addPayment($id, float $amount)
    {
        return DB::transaction(function () use ($id, $amount) {


            $purchase = Purchase::findOrFail($id);



            PurchasePayment::create([

                'purchase_id' => $purchase->id,

                'amount' => $amount,

                'payment_date' => now(),

            ]);



            $purchase->update([

                'status' => $this->paymentStatus(

                    $purchase->fresh()->paid_amount,

                    $purchase->total_amount

                ),

            ]);



            return $purchase;

        });
    }







    private function paymentStatus($paid, $total)
    {

        if ($paid >= $total && $total > 0) {

            return 'مدفوع';

        }


        if ($paid > 0) {

            return 'مدفوع جزئي';

        }


        return 'غير مدفوع';

    }







    private function generateInvoiceNumber(): string
    {

        $lastId = Purchase::max('id') + 1;


        return 'PUR-' .
            str_pad(
                $lastId,
                6,
                '0',
                STR_PAD_LEFT
            );

    }
}