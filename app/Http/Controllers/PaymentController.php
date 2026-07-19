<?php

namespace App\Http\Controllers;

use App\Interfaces\PaymentRepositoryInterface;
use App\Models\Sale;
use Illuminate\Http\Request;
use App\Exports\PaymentsExport;
use Maatwebsite\Excel\Facades\Excel;


class PaymentController extends Controller
{

    protected $paymentRepo;


    public function __construct(
        PaymentRepositoryInterface $paymentRepo
    ) {
        $this->paymentRepo = $paymentRepo;
    }



    public function index()
    {

        $payments = $this->paymentRepo->getAll();

        return view(
            'payments.index',
            compact('payments')
        );
    }





    public function show($id)
    {

        $payment =
            $this->paymentRepo->getById($id);


        if (!$payment) {

            return back()
                ->withErrors('الدفعة غير موجودة');
        }


        return view(
            'payments.show',
            compact('payment')
        );
    }





    public function create()
    {


        $sales = Sale::with([
            'customer',
            'payments'
        ])
            ->where(
                'final_amount',
                '>',
                0
            )
            ->latest()
            ->get()
            ->filter(function ($sale) {

                return $sale->remaining_amount > 0;
            });


        return view(
            'payments.create',
            compact('sales')
        );
    }





    public function store(Request $request)
    {


        $data = $request->validate([


            'sale_id' => [
                'required',
                'exists:sales,id'
            ],


            'amount' => [
                'required',
                'numeric',
                'min:0.01'
            ],


            'payment_date' => [
                'required',
                'date'
            ],


            'method' => [
                'nullable',
                'string'
            ],


            'note' => [
                'nullable',
                'string'
            ],


        ]);




        $sale = Sale::findOrFail(
            $data['sale_id']
        );




        if (
            $data['amount']
            >
            $sale->remaining_amount
        ) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'المبلغ أكبر من المتبقي'
                );
        }




        $this->paymentRepo->create($data);



        $this->updateSaleStatus($sale);




        return redirect()
            ->route('payments.index')
            ->with(
                'success',
                'تم إنشاء الدفعة بنجاح'
            );
    }






    public function edit($id)
    {

        $payment =
            $this->paymentRepo->getById($id);



        $sales = Sale::with('customer')
            ->get();



        return view(
            'payments.edit',
            compact(
                'payment',
                'sales'
            )
        );
    }







    public function update(
        Request $request,
        $id
    ) {


        $data = $request->validate([


            'amount' => 'required|numeric|min:0.01',

            'payment_date' => 'required|date',

            'method' => 'nullable|string',

            'note' => 'nullable|string',


        ]);



        $payment =
            $this->paymentRepo->getById($id);



        $this->paymentRepo
            ->update(
                $id,
                $data
            );



        $this->updateSaleStatus(
            $payment->sale
        );



        return redirect()
            ->route('payments.index')
            ->with(
                'success',
                'تم تعديل الدفعة بنجاح'
            );
    }








    public function destroy($id)
    {

        $payment =
            $this->paymentRepo->getById($id);



        $sale =
            $payment->sale;



        $this->paymentRepo->delete($id);



        $this->updateSaleStatus($sale);



        return redirect()
            ->route('payments.index')
            ->with(
                'success',
                'تم حذف الدفعة'
            );
    }







    private function updateSaleStatus($sale)
    {


        if ($sale->remaining_amount <= 0) {


            $sale->update([
                'status' => 'مدفوع'
            ]);
        } elseif ($sale->paid_amount > 0) {


            $sale->update([
                'status' => 'مدفوع جزئي'
            ]);
        } else {


            $sale->update([
                'status' => 'غير مدفوع'
            ]);
        }
    }







    public function exportExcel()
    {

        return Excel::download(
            new PaymentsExport,
            'الدفعات.xlsx'
        );
    }
}
