@extends('layouts.app')

@section('title', __('customers.customer_details'))

@section('content')

    <div class="container-fluid">

        <div class="bg-white p-4 shadow-sm rounded-3">


            <div class="d-flex justify-content-between align-items-center mb-4">


                <h4 class="mb-0">

                    <i class="bi bi-person-circle text-primary me-2"></i>

                    {{ __('customers.customer_details') }}

                </h4>



                <div>

                    <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning btn-sm">

                        <i class="bi bi-pencil"></i>

                        {{ __('customers.edit') }}

                    </a>


                    <a href="{{ route('customers.index') }}" class="btn btn-secondary btn-sm">

                        <i class="bi bi-arrow-right"></i>

                        {{ __('customers.back') }}

                    </a>


                </div>


            </div>





            <div class="row g-4">


                <div class="col-md-3">

                    <div class="p-3 border rounded bg-light">

                        <h6 class="text-muted">

                            {{ __('customers.number') }}

                        </h6>


                        <strong>

                            {{ $customer->customer_number }}

                        </strong>


                    </div>

                </div>





                <div class="col-md-3">

                    <div class="p-3 border rounded bg-light">

                        <h6 class="text-muted">

                            {{ __('customers.name') }}

                        </h6>


                        <strong>

                            {{ $customer->name }}

                        </strong>


                    </div>

                </div>





                <div class="col-md-3">

                    <div class="p-3 border rounded bg-light">

                        <h6 class="text-muted">

                            {{ __('customers.phone') }}

                        </h6>


                        {{ $customer->phone ?? '-' }}


                    </div>

                </div>





                <div class="col-md-3">

                    <div class="p-3 border rounded bg-light">

                        <h6 class="text-muted">

                            {{ __('customers.status') }}

                        </h6>


                        @if($customer->is_active)

                            <span class="badge bg-success">

                                {{ __('customers.active') }}

                            </span>

                        @else

                            <span class="badge bg-danger">

                                {{ __('customers.inactive') }}

                            </span>

                        @endif


                    </div>

                </div>




                <div class="col-md-4">

                    <div class="p-3 border rounded bg-light">


                        <h6 class="text-muted">

                            {{ __('customers.opening_balance') }}

                        </h6>


                        {{ number_format($customer->opening_balance, 2) }}


                    </div>

                </div>





                <div class="col-md-4">

                    <div class="p-3 border rounded bg-light">


                        <h6 class="text-muted">

                            {{ __('customers.credit_limit') }}

                        </h6>


                        {{ number_format($customer->credit_limit, 2) }}


                    </div>

                </div>





                <div class="col-md-4">

                    <div class="p-3 border rounded bg-light">


                        <h6 class="text-muted">

                            {{ __('customers.current_balance') }}

                        </h6>


                        <strong class="text-danger">

                            {{ number_format($customer->balance, 2) }}

                        </strong>


                    </div>

                </div>





                <div class="col-md-12">

                    <div class="p-3 border rounded bg-light">


                        <h6 class="text-muted">

                            {{ __('customers.address') }}

                        </h6>


                        {{ $customer->address ?? '-' }}


                    </div>

                </div>


            </div>





            @if($customer->notes)


                <hr class="my-4">


                <h6 class="text-muted">

                    {{ __('customers.notes') }}

                </h6>


                <div class="alert alert-light">

                    {{ $customer->notes }}

                </div>


            @endif






            <hr class="my-4">


            <h5 class="mb-3">

                <i class="bi bi-receipt"></i>

                {{ __('customers.customer_sales') }}

            </h5>





            @if($customer->sales->count())


                <div class="table-responsive">


                    <table class="table table-bordered text-center align-middle">


                        <thead class="table-light">

                            <tr>

                              <th>
                                    {{ __('sales.invoice_number') }}
                                </th>

                                <th>{{ __('customers.sale_date') }}</th>

                                <th>{{ __('customers.total_amount') }}</th>

                                <th>{{ __('customers.status') }}</th>


                            </tr>

                        </thead>



                        <tbody>


                            @foreach($customer->sales as $sale)


                                <tr>

                                      <td>
                                            {{ $sale->invoice_number }}


                                    </td>


                                    <td>

                                        {{ $sale->sale_date }}

                                    </td>


                                    <td>

                                        {{ number_format($sale->total_amount, 2) }}

                                    </td>


                                    <td>


                                        @if($sale->is_paid)

                                            <span class="badge bg-success">

                                                {{ __('customers.paid') }}

                                            </span>

                                        @else

                                            <span class="badge bg-warning">

                                                {{ __('customers.unpaid') }}

                                            </span>

                                        @endif


                                    </td>


                                </tr>


                            @endforeach


                        </tbody>


                    </table>


                </div>


            @else


                <div class="alert alert-secondary">

                    {{ __('customers.no_sales_for_customer') }}

                </div>


            @endif


        </div>

    </div>


@endsection