@extends('layouts.app')

@section('title', __('suppliers.supplier_details'))

@section('content')

    <div class="container-fluid">

        <div class="bg-white p-4 shadow-sm rounded-3">


            <div class="d-flex justify-content-between align-items-center mb-4">


                <h4 class="mb-0">

                    <i class="bi bi-person-vcard text-primary me-2"></i>

                    {{ __('suppliers.supplier_details') }}

                </h4>



                <div>


                    <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-warning btn-sm">

                        <i class="bi bi-pencil"></i>

                        {{ __('suppliers.edit') }}

                    </a>



                    <a href="{{ route('suppliers.index') }}" class="btn btn-secondary btn-sm">

                        <i class="bi bi-arrow-right"></i>

                        {{ __('suppliers.back') }}

                    </a>


                </div>


            </div>




            <div class="row g-4">



                <div class="col-md-4">

                    <div class="p-3 border rounded bg-light">

                        <h6 class="text-muted">

                            {{ __('suppliers.number') }}

                        </h6>

                        <p class="fs-5 fw-bold mb-0">

                            {{ $supplier->supplier_number }}

                        </p>

                    </div>

                </div>





                <div class="col-md-4">

                    <div class="p-3 border rounded bg-light">

                        <h6 class="text-muted">

                            {{ __('suppliers.name') }}

                        </h6>

                        <p class="fs-5 fw-bold mb-0">

                            {{ $supplier->name }}

                        </p>

                    </div>

                </div>





                <div class="col-md-4">

                    <div class="p-3 border rounded bg-light">

                        <h6 class="text-muted">

                            {{ __('suppliers.company') }}

                        </h6>

                        <p class="fs-5 fw-bold mb-0">

                            {{ $supplier->company ?? '—' }}

                        </p>

                    </div>

                </div>





                <div class="col-md-4">

                    <div class="p-3 border rounded bg-light">

                        <h6 class="text-muted">

                            {{ __('suppliers.phone') }}

                        </h6>

                        <p class="fs-5 fw-bold mb-0">

                            {{ $supplier->phone ?? '—' }}

                        </p>

                    </div>

                </div>





                <div class="col-md-4">

                    <div class="p-3 border rounded bg-light">

                        <h6 class="text-muted">

                            {{ __('suppliers.opening_balance') }}

                        </h6>

                        <p class="fs-5 fw-bold mb-0">

                            {{ number_format($supplier->opening_balance, 2) }}

                        </p>

                    </div>

                </div>





                <div class="col-md-4">

                    <div class="p-3 border rounded bg-light">

                        <h6 class="text-muted">

                            {{ __('suppliers.address') }}

                        </h6>

                        <p class="mb-0">

                            {{ $supplier->address ?? '—' }}

                        </p>

                    </div>

                </div>



            </div>





            @if($supplier->note)

                <hr class="my-4">


                <h6 class="text-muted">

                    {{ __('suppliers.note') }}

                </h6>


                <div class="alert alert-light">

                    {{ $supplier->note }}

                </div>

            @endif






            @if($supplier->purchases && $supplier->purchases->count())


                <hr class="my-4">


                <h5 class="mb-3">

                    <i class="bi bi-cart-check"></i>

                    {{ __('suppliers.supplier_purchases') }}

                </h5>



                <div class="table-responsive">


                    <table class="table table-bordered text-center align-middle">


                        <thead class="table-light">

                            <tr>

                                <th>
                                    {{ __('suppliers.invoice_number') }}
                                </th>


                                <th>
                                    {{ __('suppliers.purchase_date') }}
                                </th>


                                <th>
                                    {{ __('suppliers.total_amount') }}
                                </th>




                            </tr>


                        </thead>




                        <tbody>


                            @foreach($supplier->purchases as $purchase)


                                <tr>


                                    <td>

                                        {{ $purchase->invoice_number }}

                                    </td>


                                    <td>

                                        {{ $purchase->purchase_date->format('Y-m-d') }}

                                    </td>


                                    <td>

                                        {{ number_format($purchase->total_amount, 2) }}

                                    </td>





                                </tr>


                            @endforeach


                        </tbody>


                    </table>


                </div>


            @endif



        </div>

    </div>


@endsection