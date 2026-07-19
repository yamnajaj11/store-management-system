<?php

namespace App\Repositories;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Payment;
use App\Interfaces\SaleRepositoryInterface;
use App\Services\StockService;
use Illuminate\Support\Facades\DB;


class SaleRepository implements SaleRepositoryInterface
{

    protected StockService $stockService;



    public function __construct(
        StockService $stockService
    ) {

        $this->stockService = $stockService;

    }





    public function all()
    {
        return Sale::with([
            'customer',
            'items.product',
            'payments'
        ])
            ->latest()
            ->get();
    }






    public function find(int $id)
    {
        return Sale::with([
            'customer',
            'items.product',
            'payments'
        ])
            ->findOrFail($id);
    }






    public function create(array $data)
    {

        return DB::transaction(function () use ($data) {


            $total = 0;



            foreach ($data['items'] as &$item) {


                $unitPrice = $item['unit_price'];


                $discount = $item['discount'] ?? 0;



                $finalPrice =
                    $unitPrice -
                    (($unitPrice * $discount) / 100);



                $item['discount'] = $discount;


                $item['unit_price'] = $unitPrice;


                $item['subtotal'] =
                    $item['quantity'] * $finalPrice;



                $total += $item['subtotal'];

            }






            $invoiceDiscount =
                $data['discount'] ?? 0;




            $finalAmount =
                $total -
                (($total * $invoiceDiscount) / 100);







            $sale = Sale::create([


                'invoice_number' =>
                    $this->generateInvoiceNumber(),



                'customer_id' =>
                    $data['customer_id'],



                'total_amount' =>
                    $total,



                'discount' =>
                    $invoiceDiscount,



                'final_amount' =>
                    $finalAmount,



                'status' =>
                    $data['status'],



                'sale_date' =>
                    $data['sale_date'],


            ]);








            if ($data['status'] === 'مدفوع') {


                Payment::create([

                    'sale_id' => $sale->id,

                    'amount' => $finalAmount,

                    'method' => 'كاش',

                    'payment_date' => now(),

                    'note' => 'دفعة كاملة عند إنشاء الفاتورة',

                ]);


            }








            if ($data['status'] === 'مدفوع جزئي') {


                if (!empty($data['paid_amount'])) {


                    if ($data['paid_amount'] > $finalAmount) {


                        throw new \Exception(
                            'المبلغ المدفوع أكبر من قيمة الفاتورة'
                        );


                    }



                    Payment::create([


                        'sale_id' => $sale->id,

                        'amount' => $data['paid_amount'],

                        'method' => 'كاش',

                        'payment_date' => now(),

                        'note' => 'دفعة جزئية عند إنشاء الفاتورة',

                    ]);


                }


            }








            foreach ($data['items'] as $item) {



                $product =
                    Product::findOrFail(
                        $item['product_id']
                    );





                if ($product->stock < $item['quantity']) {


                    throw new \Exception(

                        __('sales.stock_not_enough')
                        .
                        ': '
                        .
                        $product->name

                    );


                }





                $sale->items()->create([


                    'product_id' =>
                        $item['product_id'],



                    'quantity' =>
                        $item['quantity'],



                    'unit_price' =>
                        $item['unit_price'],



                    'discount' =>
                        $item['discount'],



                    'subtotal' =>
                        $item['subtotal'],


                ]);







                $this->stockService->decrease(


                    $product,


                    $item['quantity'],


                    'sale',


                    $sale,


                    'بيع فاتورة رقم ' .
                    $sale->invoice_number


                );



            }






            return $sale;


        });


    }









    public function update(
        int $id,
        array $data
    ) {


        return DB::transaction(function () use ($id, $data) {



            $sale = $this->find($id);






            foreach ($sale->items as $item) {


                $product =
                    Product::findOrFail(
                        $item->product_id
                    );



                $this->stockService->increase(

                    $product,

                    $item->quantity,

                    'sale_return',

                    $sale,

                    'إرجاع كمية بسبب تعديل الفاتورة'

                );


            }







            $sale->items()->delete();






            $total = 0;






            foreach ($data['items'] as &$item) {



                $unitPrice =
                    $item['unit_price'];



                $discount =
                    $item['discount'] ?? 0;




                $finalPrice =
                    $unitPrice -
                    (($unitPrice * $discount) / 100);




                $item['subtotal'] =
                    $item['quantity'] * $finalPrice;



                $item['discount'] =
                    $discount;



                $total += $item['subtotal'];


            }






            $invoiceDiscount =
                $data['discount'] ?? 0;



            $finalAmount =
                $total -
                (($total * $invoiceDiscount) / 100);







            $sale->update([


                'customer_id' =>
                    $data['customer_id'],


                'total_amount' =>
                    $total,


                'discount' =>
                    $invoiceDiscount,


                'final_amount' =>
                    $finalAmount,


                'status' =>
                    $data['status'],


                'sale_date' =>
                    $data['sale_date'],


            ]);







            foreach ($data['items'] as $item) {


                $product =
                    Product::findOrFail(
                        $item['product_id']
                    );




                if ($product->stock < $item['quantity']) {


                    throw new \Exception(
                        __('sales.stock_not_enough')
                        .
                        ': '
                        .
                        $product->name
                    );


                }





                $sale->items()->create([


                    'product_id' =>
                        $item['product_id'],


                    'quantity' =>
                        $item['quantity'],


                    'unit_price' =>
                        $item['unit_price'],


                    'discount' =>
                        $item['discount'],


                    'subtotal' =>
                        $item['subtotal'],


                ]);






                $this->stockService->decrease(

                    $product,

                    $item['quantity'],

                    'sale',

                    $sale,

                    'تعديل فاتورة عميل'

                );



            }






            return $sale;


        });


    }








    public function delete(int $id)
    {

        return DB::transaction(function () use ($id) {


            $sale = $this->find($id);




            foreach ($sale->items as $item) {


                $product =
                    Product::findOrFail(
                        $item->product_id
                    );



                $this->stockService->increase(

                    $product,

                    $item->quantity,

                    'sale_return',

                    $sale,

                    'إلغاء فاتورة عميل'

                );


            }





            return $sale->delete();


        });


    }








    public function generateInvoiceNumber(): string
    {

        $last =
            Sale::max('id') + 1;



        return 'INV-' .
            str_pad(
                $last,
                6,
                '0',
                STR_PAD_LEFT
            );

    }


}