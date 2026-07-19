@extends('layouts.app')

@section('title', __('suppliers.statement'))

@section('content')

    <div class="container-fluid">

        <div class="bg-white p-4 shadow-sm rounded-3">


            <div class="d-flex justify-content-between align-items-center mb-4">

                <h4 class="mb-0">

                    <i class="bi bi-file-earmark-text text-primary me-2"></i>

                    {{ __('suppliers.statement') }}

                </h4>


                <a href="{{ route('suppliers.show', $supplier->id) }}" class="btn btn-secondary btn-sm">

                    <i class="bi bi-arrow-right"></i>

                    {{ __('suppliers.back') }}

                </a>

            </div>




            {{-- معلومات المورد --}}

            <div class="row g-3 mb-4">


                <div class="col-md-3">

                    <div class="border rounded p-3 bg-light">

                        <small class="text-muted">
                            {{ __('suppliers.number') }}
                        </small>

                        <h5 class="mb-0">
                            {{ $supplier->supplier_number }}
                        </h5>

                    </div>

                </div>




                <div class="col-md-3">

                    <div class="border rounded p-3 bg-light">

                        <small class="text-muted">
                            {{ __('suppliers.name') }}
                        </small>

                        <h5 class="mb-0">
                            {{ $supplier->name }}
                        </h5>

                    </div>

                </div>




                <div class="col-md-3">

                    <div class="border rounded p-3 bg-light">

                        <small class="text-muted">
                            {{ __('suppliers.opening_balance') }}
                        </small>

                        <h5 class="mb-0">

                            {{ number_format($supplier->opening_balance, 2) }}

                        </h5>

                    </div>

                </div>




                <div class="col-md-3">

                    <div class="border rounded p-3 bg-light">

                        <small class="text-muted">
                            {{ __('suppliers.current_balance') }}
                        </small>

                        <h5 class="mb-0 text-danger">

                            {{ number_format($supplier->balance, 2) }}

                        </h5>

                    </div>

                </div>


            </div>





            {{-- جدول الحركات --}}

            <div class="table-responsive">


                <table class="table table-bordered text-center align-middle">


                    <thead class="table-light">

                        <tr>

                            <th>
                                {{ __('suppliers.date') }}
                            </th>


                            <th>
                                {{ __('suppliers.description') }}
                            </th>


                            <th>
                                {{ __('suppliers.debit') }}
                            </th>


                            <th>
                                {{ __('suppliers.credit') }}
                            </th>


                            <th>
                                {{ __('suppliers.balance') }}
                            </th>

                        </tr>


                    </thead>




                    <tbody>


                        @php

                            $balance = $supplier->opening_balance;

                        @endphp




                        {{-- الرصيد الافتتاحي --}}

                        <tr>

                            <td>
                                {{ $supplier->created_at->format('Y-m-d') }}
                            </td>


                            <td>
                                {{ __('suppliers.opening_balance_entry') }}
                            </td>


                            <td>
                                {{ number_format($supplier->opening_balance, 2) }}
                            </td>


                            <td>
                                0
                            </td>


                            <td>
                                {{ number_format($balance, 2) }}
                            </td>

                        </tr>





                        {{-- المشتريات --}}

                        @foreach($supplier->purchases as $purchase)


                            @php

                                $balance += $purchase->total_amount;

                            @endphp



                            <tr>


                                <td>
                                    {{ $purchase->purchase_date->format('Y-m-d') }}
                                </td>


                                <td>

                                    {{ __('suppliers.purchase_invoice') }}

                                    {{ $purchase->invoice_number }}

                                </td>


                                <td>

                                    {{ number_format($purchase->total_amount, 2) }}

                                </td>


                                <td>
                                    0
                                </td>


                                <td>

                                    {{ number_format($balance, 2) }}

                                </td>


                            </tr>






                            {{-- الدفعات --}}

                            @foreach($purchase->payments as $payment)


                                @php

                                    $balance -= $payment->amount;

                                @endphp


                                <tr>


                                    <td>
                                        {{ $payment->payment_date->format('Y-m-d') }}
                                    </td>


                                    <td>

                                        {{ __('suppliers.payment_supplier') }}

                                        <br>

                                        <small class="text-muted">

                                            {{ __('suppliers.for_invoice') }}

                                            {{ $purchase->invoice_number }}

                                        </small>

                                    </td>


                                    <td>
                                        0
                                    </td>


                                    <td>

                                        {{ number_format($payment->amount, 2) }}

                                    </td>


                                    <td>

                                        {{ number_format($balance, 2) }}

                                    </td>


                                </tr>


                            @endforeach








                            {{-- المرتجعات --}}


                            @foreach($purchase->returns as $return)


                                @php

                                    $balance -= $return->total_amount;

                                @endphp



                                <tr>


                                    <td>

                                        {{ $return->return_date->format('Y-m-d') }}

                                    </td>


                                    <td>


                                        {{ __('suppliers.purchase_return') }}

                                        {{ $return->return_number }}


                                        <br>


                                        <small class="text-muted">


                                            {{ __('suppliers.for_invoice') }}

                                            {{ $purchase->invoice_number }}


                                        </small>


                                    </td>


                                    <td>

                                        0

                                    </td>


                                    <td>

                                        {{ number_format($return->total_amount, 2) }}

                                    </td>


                                    <td>

                                        {{ number_format($balance, 2) }}

                                    </td>


                                </tr>


                            @endforeach



                        @endforeach



                    </tbody>


                </table>


            </div>



        </div>

    </div>


@endsection