@extends('layouts.app')

@section('title', __('payments.index_title'))

@section('content')

<div class="container-fluid">

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">


        {{-- Header --}}
        <div class="card-header bg-white border-0 p-4">


            <div class="d-flex justify-content-between align-items-center">


                <div>

                    <h4 class="fw-bold mb-1">

                        <i class="bi bi-cash-stack text-success me-2"></i>

                        {{ __('payments.index_title') }}

                    </h4>


                    <small class="text-muted">

                        {{ __('payments.list_description') }}

                    </small>


                </div>





                <a href="{{ route('payments.create') }}"
                   class="btn btn-primary">

                    <i class="bi bi-plus-circle me-1"></i>

                    {{ __('payments.create_new') }}

                </a>



            </div>


        </div>






        <div class="card-body p-4">



            @if($payments->isEmpty())


                <div class="alert alert-info text-center rounded-3">

                    <i class="bi bi-info-circle me-2"></i>

                    {{ __('payments.no_payments') }}

                </div>



            @else




            <div class="table-responsive">


                <table class="table table-bordered align-middle text-center">


                    <thead class="table-light">


                        <tr>

                            <th>#</th>


                            <th>
                                {{ __('payments.invoice_number') }}
                            </th>


                            <th>
                                {{ __('payments.customer') }}
                            </th>


                            <th>
                                {{ __('payments.amount') }}
                            </th>


                            <th>
                                {{ __('payments.method') }}
                            </th>


                            <th>
                                {{ __('payments.payment_date') }}
                            </th>


                            <th>
                                {{ __('payments.actions') }}
                            </th>


                        </tr>


                    </thead>






                    <tbody>


                    @foreach($payments as $payment)


                        <tr>


                            <td>

                                {{ $loop->iteration }}

                            </td>





                            <td class="fw-bold text-primary">


                                {{ $payment->sale->invoice_number ?? '-' }}


                            </td>







                            <td>


                                {{ $payment->sale->customer->name ?? 'عميل عام' }}


                            </td>







                            <td class="fw-bold text-success">


                                {{ number_format($payment->amount,2) }}

                                {{ __('payments.currency') }}


                            </td>








                            <td>


                                <span class="badge bg-light text-dark">


                                    {{ $payment->method ?? __('payments.cash') }}


                                </span>


                            </td>









                            <td>


                                {{ $payment->payment_date->format('Y-m-d H:i') }}


                            </td>









                            <td>



                                <a href="{{ route('payments.show',$payment->id) }}"
                                   class="btn btn-sm btn-info text-white">

                                    <i class="bi bi-eye"></i>

                                </a>






                                <a href="{{ route('payments.edit',$payment->id) }}"
                                   class="btn btn-sm btn-warning text-white">

                                    <i class="bi bi-pencil-square"></i>

                                </a>







                                <form action="{{ route('payments.destroy',$payment->id) }}"
                                      method="POST"
                                      class="d-inline">


                                    @csrf

                                    @method('DELETE')



                                    <button type="submit"
                                            onclick="return confirm('{{ __('payments.delete_confirm') }}')"
                                            class="btn btn-sm btn-danger">


                                        <i class="bi bi-trash"></i>


                                    </button>


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


</div>


@endsection