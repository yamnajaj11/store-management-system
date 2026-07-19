<?php

namespace App\Http\Controllers;


use App\Interfaces\SaleRepositoryInterface;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalesExport;



class SaleController extends Controller
{


    protected SaleRepositoryInterface $saleRepo;



    public function __construct(
        SaleRepositoryInterface $saleRepo
    ) {

        $this->saleRepo = $saleRepo;

    }






    public function index()
    {

        $sales = $this->saleRepo->all();

        return view(
            'sales.index',
            compact('sales')
        );

    }







    public function create()
    {

        $customers = Customer::orderBy('name')->get();

        $products = Product::orderBy('name')->get();


        return view(
            'sales.create',
            compact(
                'customers',
                'products'
            )
        );

    }








    public function store(Request $request)
    {

        $data = $request->validate([


            'customer_id' => [
                'required',
                'exists:customers,id'
            ],


            'sale_date' => [
                'required',
                'date'
            ],


            'status' => [
                'required',
                'in:مدفوع,مدفوع جزئي,غير مدفوع'
            ],


            'paid_amount' => [
                'nullable',
                'numeric',
                'min:0'
            ],


            'discount' => [
                'nullable',
                'numeric',
                'min:0',
                'max:100'
            ],


            'items' => [
                'required',
                'array',
                'min:1'
            ],


            'items.*.product_id' => [
                'required',
                'exists:products,id'
            ],


            'items.*.quantity' => [
                'required',
                'integer',
                'min:1'
            ],


         'items.*.unit_price' => [
    'required',
    'numeric',
    'min:0'
],


            'items.*.discount' => [
                'nullable',
                'numeric',
                'min:0',
                'max:100'
            ],


        ]);







        if (
            $data['status'] === 'مدفوع جزئي'
            &&
            empty($data['paid_amount'])
        ) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'يجب إدخال مبلغ الدفعة'
                );

        }







        if ($data['status'] !== 'مدفوع جزئي') {

            $data['paid_amount'] = 0;

        }







        try {


            $this->saleRepo->create($data);



            return redirect()
                ->route('sales.index')
                ->with(
                    'success',
                    __('sales.created')
                );



        } catch (\Exception $e) {


            return back()
                ->withInput()
                ->with(
                    'error',
                    $e->getMessage()
                );

        }


    }









    public function show($id)
    {

        $sale = $this->saleRepo->find($id);


        return view(
            'sales.show',
            compact('sale')
        );

    }









    public function edit($id)
    {

        $sale = $this->saleRepo->find($id);


        $customers = Customer::orderBy('name')->get();


        $products = Product::orderBy('name')->get();



        return view(
            'sales.edit',
            compact(
                'sale',
                'customers',
                'products'
            )
        );

    }









    public function update(
        Request $request,
        $id
    ) {


        $data = $request->validate([



            'customer_id' => [
                'required',
                'exists:customers,id'
            ],


            'sale_date' => [
                'required',
                'date'
            ],


            'status' => [
                'required',
                'in:مدفوع,مدفوع جزئي,غير مدفوع'
            ],


            'paid_amount' => [
                'nullable',
                'numeric',
                'min:0'
            ],


            'discount' => [
                'nullable',
                'numeric',
                'min:0',
                'max:100'
            ],


            'items' => [
                'required',
                'array',
                'min:1'
            ],


            'items.*.product_id' => [
                'required',
                'exists:products,id'
            ],


            'items.*.quantity' => [
                'required',
                'integer',
                'min:1'
            ],



       'items.*.unit_price' => [
    'required',
    'numeric',
    'min:0'
],


            'items.*.discount' => [
                'nullable',
                'numeric',
                'min:0',
                'max:100'
            ],


        ]);







        try {


            $this->saleRepo->update(
                $id,
                $data
            );



            return redirect()
                ->route('sales.index')
                ->with(
                    'success',
                    __('sales.updated')
                );



        } catch (\Exception $e) {


            return back()
                ->withInput()
                ->with(
                    'error',
                    $e->getMessage()
                );

        }



    }









    public function destroy($id)
    {

        $this->saleRepo->delete($id);



        return redirect()
            ->route('sales.index')
            ->with(
                'success',
                __('sales.deleted')
            );

    }









    public function exportExcel()
    {

        return Excel::download(
            new SalesExport,
            'sales.xlsx'
        );

    }



}