@extends('layouts.app')

@section('title', __('purchases.index_title'))

@section('content')

    <div class="container-fluid">

        <div class="bg-white p-4 shadow-sm rounded-3">


            <div class="d-flex justify-content-between align-items-center mb-4">


                <h4 class="mb-0">

                    <i class="bi bi-cart-check text-success me-2"></i>

                    {{ __('purchases.index_title') }}

                </h4>



                <div class="d-flex gap-2">


                    <a href="{{ route('purchase_returns.index') }}" class="btn btn-warning btn-sm">

                        <i class="bi bi-arrow-counterclockwise"></i>

                        {{ __('purchases.view_returns') }}

                    </a>



                    <a href="{{ route('purchases.create') }}" class="btn btn-primary btn-sm">

                        <i class="bi bi-plus-lg"></i>

                        {{ __('purchases.create_new') }}

                    </a>


                </div>


            </div>





            @if($purchases->isEmpty())


                <div class="alert alert-info text-center">

                    {{ __('purchases.no_purchases') }}

                </div>


            @else



                <div class="table-responsive">


                    <table class="table table-bordered align-middle text-center">


                        <thead class="table-light">

                            <tr>

                                <th>
                                    {{ __('purchases.invoice_number') }}
                                </th>


                                <th>
                                    {{ __('purchases.supplier') }}
                                </th>


                                <th>
                                    {{ __('purchases.total_amount') }}
                                </th>


                                <th>
                                    {{ __('purchases.status') }}
                                </th>


                                <th>
                                    {{ __('purchases.purchase_date') }}
                                </th>


                                <th>
                                    {{ __('purchases.actions') }}
                                </th>


                            </tr>


                        </thead>




                        <tbody>


                            @foreach($purchases as $purchase)


                                <tr>


                                    <td class="fw-semibold">

                                        {{ $purchase->invoice_number }}

                                    </td>



                                    <td>

                                        {{ $purchase->supplier->name }}

                                    </td>



                                    <td>

                                        {{ rtrim(rtrim(number_format($purchase->total_amount, 2, '.', ''), '0'), '.') }}

                                    </td>



                                    <td>


                                        @if($purchase->status == 'مدفوع')


                                            <span class="badge bg-success">

                                                {{ __('purchases.paid') }}

                                            </span>


                                        @elseif($purchase->status == 'مدفوع جزئي')


                                            <span class="badge bg-warning">

                                                {{ __('purchases.partial') }}

                                            </span>


                                        @else


                                            <span class="badge bg-danger">

                                                {{ __('purchases.unpaid') }}

                                            </span>


                                        @endif


                                    </td>




                                    <td>

                                        {{ \Carbon\Carbon::parse($purchase->purchase_date)->format('Y-m-d') }}

                                    </td>




                                    <td>



                                        <a href="{{ route('purchases.show', $purchase->id) }}"
                                            class="btn btn-sm btn-info text-white">

                                            <i class="bi bi-eye"></i>

                                        </a>




                                        <a href="{{ route('purchases.edit', $purchase->id) }}"
                                            class="btn btn-sm btn-warning text-white">

                                            <i class="bi bi-pencil-square"></i>

                                        </a>




                                        @if($purchase->status != 'مدفوع')


                                            <a href="{{ route('purchases.payment', $purchase->id) }}" class="btn btn-sm btn-success">


                                                <i class="bi bi-cash"></i>

                                                {{ __('purchases.pay') }}


                                            </a>


                                        @endif





                                        <form action="{{ route('purchases.destroy', $purchase->id) }}" method="POST"
                                            class="d-inline">


                                            @csrf

                                            @method('DELETE')

                                            @if($purchase->paid_amount >= $purchase->total_amount)


                                                <a href="{{ route('purchase_returns.create', $purchase->id) }}" class="btn btn-warning">

                                                    <i class="bi bi-arrow-counterclockwise"></i>

                                                </a>


                                            @else



                                                <button onclick="return confirm('{{ __('purchases.confirm_delete') }}')"
                                                    class="btn btn-sm btn-danger">


                                                    <i class="bi bi-trash"></i>


                                                </button>


                                            @endif


                                        </form>



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