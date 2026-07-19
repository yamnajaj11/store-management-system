@extends('layouts.app')

@section('title', __('payments.show_title'))

@section('content')

<div class="container-fluid">


    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">



        {{-- Header --}}
        <div class="card-header bg-white border-0 p-4">


            <div class="d-flex justify-content-between align-items-center">


                <div>


                    <h3 class="fw-bold mb-1">

                        <i class="bi bi-cash-coin text-success me-2"></i>

                        {{ __('payments.show_title') }}

                    </h3>



                    <span class="text-muted">


                        {{ __('payments.invoice_number') }} :

                        {{ $payment->sale->invoice_number ?? '-' }}


                    </span>



                </div>





                <div class="d-flex gap-2">



                    <a href="{{ route('payments.index') }}"
                       class="btn btn-secondary">


                        <i class="bi bi-arrow-right"></i>

                        {{ __('payments.back') }}


                    </a>







                    <a href="{{ route('payments.exportExcel') }}"
                       class="btn btn-success">


                        <i class="bi bi-file-earmark-excel"></i>

                        {{ __('payments.download_excel') }}


                    </a>




                </div>



            </div>


        </div>









        <div class="card-body p-4">





            {{-- معلومات الدفعة --}}


            <div class="row g-3 mb-4">





                <div class="col-md-4">


                    <div class="bg-light rounded-4 p-3">


                        <small class="text-muted d-block">

                            {{ __('payments.customer') }}

                        </small>



                        <h6 class="fw-bold mb-0">


                            {{ $payment->sale->customer->name ?? 'عميل عام' }}


                        </h6>


                    </div>


                </div>









                <div class="col-md-4">


                    <div class="bg-light rounded-4 p-3">


                        <small class="text-muted d-block">

                            {{ __('payments.amount') }}

                        </small>



                        <h6 class="fw-bold text-success mb-0">


                            {{ number_format($payment->amount,2) }}

                            {{ __('payments.currency') }}


                        </h6>


                    </div>


                </div>









                <div class="col-md-4">


                    <div class="bg-light rounded-4 p-3">


                        <small class="text-muted d-block">

                            {{ __('payments.payment_date') }}

                        </small>



                        <h6 class="fw-bold mb-0">


                            {{ $payment->payment_date->format('Y-m-d H:i') }}


                        </h6>


                    </div>


                </div>




            </div>









            {{-- تفاصيل الفاتورة --}}


            <div class="card border rounded-4 mb-4">



                <div class="card-header bg-light">


                    <h6 class="fw-bold mb-0">


                        <i class="bi bi-receipt text-primary me-2"></i>


                        {{ __('payments.invoice_information') }}


                    </h6>


                </div>





                <div class="card-body">


                    <div class="table-responsive">


                        <table class="table table-bordered text-center align-middle">



                            <thead class="table-light">


                                <tr>


                                    <th>

                                        {{ __('payments.invoice_number') }}

                                    </th>


                                    <th>

                                        {{ __('payments.total') }}

                                    </th>


                                    <th>

                                        {{ __('payments.paid_amount') }}

                                    </th>


                                    <th>

                                        {{ __('payments.remaining_amount') }}

                                    </th>


                                    <th>

                                        {{ __('payments.status') }}

                                    </th>


                                </tr>


                            </thead>






                            <tbody>


                                <tr>


                                    <td class="fw-bold text-primary">


                                        {{ $payment->sale->invoice_number ?? '-' }}


                                    </td>





                                    <td>


                                        {{ number_format($payment->sale->final_amount ?? 0,2) }}

                                        {{ __('payments.currency') }}


                                    </td>





                                    <td class="text-success fw-bold">


                                        {{ number_format($payment->sale->paid_amount ?? 0,2) }}

                                        {{ __('payments.currency') }}


                                    </td>





                                    <td class="text-danger fw-bold">


                                        {{ number_format($payment->sale->remaining_amount ?? 0,2) }}

                                        {{ __('payments.currency') }}


                                    </td>






                                    <td>


                                        @if(($payment->sale->remaining_amount ?? 0) <= 0)


                                            <span class="badge bg-success rounded-pill">

                                                {{ __('payments.paid') }}

                                            </span>


                                        @elseif(($payment->sale->paid_amount ?? 0) > 0)


                                            <span class="badge bg-warning text-dark rounded-pill">

                                                {{ __('payments.partial_paid') }}

                                            </span>


                                        @else


                                            <span class="badge bg-danger rounded-pill">

                                                {{ __('payments.unpaid') }}

                                            </span>


                                        @endif



                                    </td>



                                </tr>



                            </tbody>



                        </table>



                    </div>



                </div>



            </div>









            {{-- ملاحظات الدفع --}}


            <div class="card bg-light border-0 rounded-4">


                <div class="card-body">


                    <h6 class="fw-bold">


                        <i class="bi bi-chat-left-text text-secondary me-2"></i>


                        {{ __('payments.note') }}


                    </h6>



                    <p class="mb-0 text-muted">


                        {{ $payment->note ?? '-' }}


                    </p>


                </div>


            </div>








        </div>


    </div>


</div>


@endsection