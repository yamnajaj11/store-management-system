@extends('layouts.app')

@section('title', __('purchase_returns.index_title'))

@section('content')

    <div class="container-fluid">

        <div class="card shadow-sm border-0 rounded-4">

            <div class="card-body p-4">


                <div class="d-flex justify-content-between align-items-center mb-4">


                    <div>

                        <h4 class="fw-bold mb-1">

                            <i class="bi bi-arrow-counterclockwise text-danger"></i>

                            {{ __('purchase_returns.index_title') }}

                        </h4>

                    </div>



                    <a href="{{ route('purchases.index') }}" class="btn btn-secondary">

                        <i class="bi bi-arrow-left"></i>

                        {{ __('purchase_returns.back') }}

                    </a>


                </div>



                <div class="table-responsive">


                    <table class="table table-bordered table-hover text-center align-middle">

                        <thead class="table-light">

                            <tr>

                                <th>
                                    {{ __('purchase_returns.invoice_number') }}
                                </th>

                                <th>
                                    {{ __('purchase_returns.supplier') }}
                                </th>

                                <th>
                                    {{ __('purchase_returns.return_date') }}
                                </th>

                                <th>
                                    {{ __('purchase_returns.products') }}
                                </th>

                                <th>
                                    {{ __('purchase_returns.quantity') }}
                                </th>

                                <th>
                                    {{ __('purchase_returns.total') }}
                                </th>

                                <th>
                                    {{ __('purchase_returns.actions') }}
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($returns as $return)

                                <tr>

                                    <td class="fw-bold text-danger">
                                        {{ $return->invoice_number }}
                                    </td>


                                    <td>
                                        {{ $return->supplier->name }}
                                    </td>


                                    <td>
                                        {{ $return->return_date->format('Y-m-d') }}
                                    </td>


                                    <td>

                                        @foreach($return->items as $item)

                                            <span class="badge bg-secondary d-block mb-1">

                                                {{ $item->product->name }}

                                            </span>

                                        @endforeach

                                    </td>



                                    <td>

                                        @foreach($return->items as $item)

                                            <span class="badge bg-success d-block mb-1">

                                                {{ $item->quantity }}

                                            </span>

                                        @endforeach

                                    </td>



                                    <td>

                                        {{ formatAmount($return->total_amount) }}

                                    </td>



                                    <td>

                                        <a href="{{ route('purchase_returns.show', $return->id) }}"
                                            class="btn btn-primary btn-sm">

                                            <i class="bi bi-eye"></i>

                                            {{ __('purchase_returns.show') }}

                                        </a>

                                    </td>


                                </tr>


                            @empty

                                <tr>

                                    <td colspan="7">

                                        {{ __('purchase_returns.no_returns') }}

                                    </td>

                                </tr>


                            @endforelse


                        </tbody>


                    </table>

                </div>


            </div>

        </div>

    </div>


@endsection