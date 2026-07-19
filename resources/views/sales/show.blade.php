@extends('layouts.app')

@section('title', __('sales.show'))

@section('content')

<div class="container-fluid">

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">


        {{-- Header --}}

        <div class="card-header bg-white border-0 p-4">

            <div class="d-flex justify-content-between align-items-center">


                <div>

                    <h3 class="fw-bold mb-1">

                        <i class="bi bi-receipt-cutoff text-primary me-2"></i>

                        {{ __('sales.invoice') }}

                    </h3>


                    <span class="text-muted">

                        {{ __('sales.invoice_number') }} :

                        {{ $sale->invoice_number }}

                    </span>


                </div>





                <div class="d-flex gap-2">


                    <a href="{{ route('sales.index') }}"
                        class="btn btn-secondary">

                        <i class="bi bi-arrow-right"></i>

                        {{ __('sales.back') }}

                    </a>




                    <a href="{{ route('sales.exportExcel') }}"
                        class="btn btn-success">

                        <i class="bi bi-file-earmark-excel"></i>

                        Excel

                    </a>


                </div>


            </div>

        </div>








        <div class="card-body p-4">



            @php

            $paidAmount = $sale->payments->sum('amount');

            $remaining =
            max(
            0,
            $sale->final_amount - $paidAmount
            );

            @endphp








            {{-- معلومات الفاتورة --}}


            <div class="row g-3 mb-4">





                <div class="col-md-4">

                    <div class="bg-light rounded-4 p-3">


                        <small class="text-muted d-block">

                            {{ __('sales.customer') }}

                        </small>



                        <h6 class="fw-bold mb-0">


                            {{ $sale->customer->name ?? __('sales.general_customer') }}


                        </h6>



                    </div>

                </div>








                <div class="col-md-4">


                    <div class="bg-light rounded-4 p-3">


                        <small class="text-muted d-block">

                            {{ __('sales.date') }}

                        </small>



                        <h6 class="fw-bold mb-0">


                            {{ $sale->sale_date->format('Y-m-d') }}


                        </h6>



                    </div>

                </div>








                <div class="col-md-4">


                    <div class="bg-light rounded-4 p-3">


                        <small class="text-muted d-block">

                            {{ __('sales.status') }}

                        </small>





                        @if($sale->status == 'مدفوع')


                        <span class="badge bg-success rounded-pill px-3">

                            {{ __('sales.paid') }}

                        </span>




                        @elseif($sale->status == 'مدفوع جزئي')



                        <span class="badge bg-warning text-dark rounded-pill px-3">

                            {{ __('sales.partial_paid') }}

                        </span>




                        @else



                        <span class="badge bg-danger rounded-pill px-3">

                            {{ __('sales.unpaid') }}

                        </span>




                        @endif





                    </div>

                </div>



            </div>









            {{-- المنتجات --}}


            <div class="table-responsive">


                <table class="table table-bordered align-middle text-center">


                    <thead class="table-light">


                        <tr>


                            <th>
                                #
                            </th>


                            <th>
                                {{ __('sales.product') }}
                            </th>



                            <th>
                                {{ __('sales.quantity') }}
                            </th>



                            <th>
                                {{ __('sales.price') }}
                            </th>



                            <th>
                                {{ __('sales.discount') }}
                            </th>



                            <th>
                                {{ __('sales.subtotal') }}
                            </th>



                        </tr>


                    </thead>





                    <tbody>



                        @foreach($sale->items as $index=>$item)



                        <tr>


                            <td>

                                {{ $index+1 }}

                            </td>




                            <td class="fw-semibold">


                                {{ $item->product->name ?? '-' }}


                            </td>




                            <td>

                                {{ $item->quantity }}

                            </td>




                            <td>


                                {{ number_format($item->unit_price,2) }}


                            </td>




                            <td>


                                {{ $item->discount }} %


                            </td>





                            <td class="fw-bold text-primary">


                                {{ number_format($item->subtotal,2) }}


                            </td>



                        </tr>



                        @endforeach



                    </tbody>


                </table>


            </div>
        
           
{{-- الحسابات --}}

<div class="row justify-content-end mt-4">


    <div class="col-md-5">


        <div class="bg-light rounded-4 p-4">


            <div class="d-flex justify-content-between mb-3">


                <span>

                    {{ __('sales.total_amount') }}

                </span>



                <strong>


                    {{ number_format($sale->total_amount,2) }}

                    {{ __('sales.currency') }}


                </strong>



            </div>







            <div class="d-flex justify-content-between mb-3 text-danger">


                <span>

                    {{ __('sales.invoice_discount') }}

                </span>



                <strong>


                    {{ number_format($sale->discount,2) }}

                    %

                </strong>



            </div>







            <hr>







            <div class="d-flex justify-content-between mb-3">


                <span class="fw-bold">


                    {{ __('sales.final_amount') }}


                </span>



                <strong class="text-primary">


                    {{ number_format($sale->final_amount,2) }}

                    {{ __('sales.currency') }}


                </strong>



            </div>







            <div class="d-flex justify-content-between mb-3">


                <span>


                    {{ __('sales.paid_amount') }}


                </span>



                <strong class="text-success">


                    {{ number_format($paidAmount,2) }}

                    {{ __('sales.currency') }}


                </strong>



            </div>







            <div class="d-flex justify-content-between">


                <span class="fw-bold">


                    {{ __('sales.remaining_amount') }}


                </span>



                <strong class="text-danger">


                    {{ number_format($remaining,2) }}

                    {{ __('sales.currency') }}


                </strong>



            </div>


        </div>


    </div>


</div>







{{-- سجل الدفعات --}}


<div class="card border-0 shadow-sm rounded-4 mt-4">


    <div class="card-body p-4">



        <h5 class="fw-bold mb-4">


            <i class="bi bi-cash-stack text-success me-2"></i>


            {{ __('payments.history') }}


        </h5>





        <div class="table-responsive">


            <table class="table table-bordered text-center align-middle">


                <thead class="table-light">


                    <tr>


                        <th>

                            {{ __('payments.payment_date') }}

                        </th>


                        <th>

                            {{ __('payments.amount') }}

                        </th>


                        <th>

                            {{ __('payments.method') }}

                        </th>


                        <th>

                            {{ __('payments.note') }}

                        </th>


                    </tr>


                </thead>




                <tbody>



                    @forelse($sale->payments as $payment)



                    <tr>


                        <td>


                            {{ $payment->payment_date->format('Y-m-d H:i') }}


                        </td>




                        <td class="text-success fw-bold">


                            {{ number_format($payment->amount,2) }}

                            {{ __('sales.currency') }}


                        </td>




                        <td>


                            {{ $payment->method }}


                        </td>




                        <td>


                            {{ $payment->note ?? '-' }}


                        </td>



                    </tr>



                    @empty



                    <tr>


                        <td colspan="4" class="text-muted">


                            {{ __('payments.no_payments') }}


                        </td>


                    </tr>



                    @endforelse



                </tbody>


            </table>


        </div>


    </div>


</div>







            <div class="mt-5 text-center text-muted">


                <i class="bi bi-heart-fill text-danger"></i>


                {{ __('sales.thanks') }}



            </div>







        </div>


    </div>


</div>


@endsection