@extends('layouts.app')

@section('title', __('purchases.show_purchase'))

@section('content')

    <div class="container-fluid">

        <div class="bg-white p-4 shadow-sm rounded-3">


            <div class="d-flex justify-content-between align-items-center mb-4">

                <h4 class="mb-0">

                    <i class="bi bi-receipt text-primary me-2"></i>

                    {{ __('purchases.show_purchase') }}

                </h4>


                <a href="{{ route('purchases.index') }}" class="btn btn-secondary btn-sm">

                    <i class="bi bi-arrow-left"></i>

                    {{ __('purchases.back') }}

                </a>


            </div>





            {{-- معلومات الفاتورة --}}

            <div class="card mb-4">

                <div class="card-body">


                    <div class="row g-3">


                        <div class="col-md-3">

                            <strong>
                                {{ __('purchases.invoice_number') }}:
                            </strong>

                            {{ $purchase->invoice_number }}

                        </div>



                        <div class="col-md-3">

                            <strong>
                                {{ __('purchases.supplier') }}:
                            </strong>

                            {{ $purchase->supplier->name }}

                        </div>



                        <div class="col-md-3">

                            <strong>
                                {{ __('purchases.purchase_date') }}:
                            </strong>

                            {{ $purchase->purchase_date->format('Y-m-d') }}

                        </div>



                        <div class="col-md-3">

                            <strong>
                                {{ __('purchases.status') }}:
                            </strong>

                            {{ $purchase->status }}

                        </div>


                    </div>





                    <hr>





                    {{-- الملخص المالي --}}


                    <div class="row g-3">


                        <div class="col-md-3">

                            <div class="border rounded p-3 bg-light">

                                <small class="text-muted">
                                    {{ __('purchases.original_amount') }}
                                </small>


                                <h5 class="mb-0">

                                    {{ formatAmount($purchase->total_amount) }}

                                </h5>


                            </div>

                        </div>





                        <div class="col-md-3">

                            <div class="border rounded p-3 bg-light">

                                <small class="text-muted">
                                    {{ __('purchases.returned_amount') }}
                                </small>


                                <h5 class="mb-0 text-danger">

                                    {{ formatAmount($purchase->returned_amount) }}

                                </h5>


                            </div>

                        </div>





                        <div class="col-md-3">

                            <div class="border rounded p-3 bg-light">

                                <small class="text-muted">
                                    {{ __('purchases.net_amount') }}
                                </small>


                                <h5 class="mb-0 text-primary">

                                    {{ formatAmount($purchase->total_amount - $purchase->returned_amount) }}

                                </h5>


                            </div>

                        </div>





                        <div class="col-md-3">

                            <div class="border rounded p-3 bg-light">

                                <small class="text-muted">
                                    {{ __('purchases.paid_amount') }}
                                </small>


                                <h5 class="mb-0 text-success">

                                    {{ formatAmount($purchase->paid_amount) }}

                                </h5>


                            </div>

                        </div>


                    </div>





                    <div class="row g-3 mt-2">



                        <div class="col-md-4">

                            <div class="border rounded p-3">

                                <strong>
                                    {{ __('purchases.remaining_amount') }}
                                </strong>

                                <span class="ms-2 text-danger">

                                    {{ formatAmount($purchase->remaining_amount) }}

                                </span>

                            </div>

                        </div>



                        <div class="col-md-4">

                            <div class="border rounded p-3">

                                <strong>
                                    {{ __('purchases.credit_amount') }}
                                </strong>

                                <span class="ms-2 text-success">

                                    {{ formatAmount($purchase->credit_amount) }}

                                </span>

                            </div>

                        </div>




                        <div class="col-md-4">

                            <div class="border rounded p-3">

                                <strong>
                                    {{ __('purchases.items_count') }}
                                </strong>


                                <span class="ms-2">

                                    {{ $purchase->items->count() }}

                                </span>


                            </div>

                        </div>


                    </div>



                </div>

            </div>









            {{-- جدول الأصناف --}}


            <div class="table-responsive">


                <table class="table table-bordered text-center align-middle">


                    <thead class="table-light">

                        <tr>


                            <th>
                                {{ __('purchases.product') }}
                            </th>


                            <th>
                                {{ __('purchases.quantity') }}
                            </th>


                            <th>
                                {{ __('purchases.returned_quantity') }}
                            </th>


                            <th>
                                {{ __('purchases.available_quantity') }}
                            </th>


                            <th>
                                {{ __('purchases.purchase_price') }}
                            </th>


                            <th>
                                {{ __('purchases.subtotal') }}
                            </th>


                        </tr>


                    </thead>





                    <tbody>


                        @foreach($purchase->items as $item)


                            <tr>


                                <td>

                                    {{ $item->product->name }}

                                </td>



                                <td>

                                    {{ $item->quantity }}

                                </td>



                                <td>

                                    <span class="badge bg-danger">

                                        {{ $item->returned_quantity }}

                                    </span>

                                </td>



                                <td>

                                    <span class="badge bg-success">

                                        {{ $item->available_quantity }}

                                    </span>

                                </td>



                                <td>

                                    {{ formatAmount($item->price) }}

                                </td>




                                <td>

                                    {{ formatAmount($item->subtotal) }}

                                </td>


                            </tr>


                        @endforeach


                    </tbody>






                    <tfoot>

                        <tr>


                            <th colspan="5">

                                {{ __('purchases.total') }}

                            </th>


                            <th>

                                {{ formatAmount($purchase->total_amount) }}

                            </th>


                        </tr>


                    </tfoot>



                </table>


            </div>





        </div>

    </div>


@endsection