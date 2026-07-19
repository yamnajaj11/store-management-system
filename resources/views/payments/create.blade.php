@extends('layouts.app')

@section('title', __('payments.create_title'))

@section('content')

<div class="container-fluid">


    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">



        {{-- Header --}}
        <div class="card-header bg-white border-0 p-4">


            <div class="d-flex align-items-center">


                <div class="bg-success-subtle rounded-3 p-3 me-3">

                    <i class="bi bi-cash-coin fs-3 text-success"></i>

                </div>



                <div>

                    <h4 class="fw-bold mb-1">

                        {{ __('payments.create_title') }}

                    </h4>


                    <small class="text-muted">

                        {{ __('payments.create_description') }}

                    </small>


                </div>



            </div>


        </div>






        <div class="card-body p-4">



            @if(session('error'))

                <div class="alert alert-danger">

                    <i class="bi bi-exclamation-triangle me-2"></i>

                    {{ session('error') }}

                </div>

            @endif





            <form action="{{ route('payments.store') }}"
                  method="POST">


                @csrf






                {{-- اختيار الفاتورة --}}


                <div class="card bg-light border-0 rounded-4 mb-4">


                    <div class="card-body">


                        <h5 class="fw-bold mb-3">

                            <i class="bi bi-receipt text-success me-2"></i>

                            {{ __('payments.invoice_information') }}

                        </h5>





                        <div class="row g-3">






                            <div class="col-md-6">


                                <label class="form-label fw-semibold">

                                    {{ __('payments.invoice_number') }}

                                </label>




                                <select name="sale_id"
                                        id="sale_id"
                                        class="form-select rounded-3"
                                        required>


                                    <option value="">

                                        {{ __('payments.select_invoice') }}

                                    </option>



                                    @foreach($sales as $sale)


                                        <option value="{{ $sale->id }}"
                                                data-remaining="{{ $sale->remaining_amount }}">


                                            {{ $sale->invoice_number }}

                                            -
                                            {{ $sale->customer->name ?? 'عميل عام' }}

                                            ({{ number_format($sale->remaining_amount,2) }}
                                            {{ __('payments.currency') }})


                                        </option>


                                    @endforeach


                                </select>



                            </div>









                            <div class="col-md-3">


                                <label class="form-label fw-semibold">

                                    {{ __('payments.remaining_amount') }}

                                </label>



                                <input type="text"
                                       id="remaining"
                                       class="form-control rounded-3"
                                       readonly>


                            </div>






                            <div class="col-md-3">


                                <label class="form-label fw-semibold">

                                    {{ __('payments.payment_date') }}

                                </label>



                                <input type="date"
                                       name="payment_date"
                                       class="form-control rounded-3"
                                       value="{{ date('Y-m-d') }}"
                                       required>



                            </div>




                        </div>


                    </div>


                </div>









                {{-- بيانات الدفع --}}



                <div class="card bg-light border-0 rounded-4 mb-4">


                    <div class="card-body">



                        <h5 class="fw-bold mb-3">


                            <i class="bi bi-wallet2 text-success me-2"></i>

                            {{ __('payments.payment_information') }}


                        </h5>





                        <div class="row g-3">





                            <div class="col-md-4">


                                <label class="form-label fw-semibold">

                                    {{ __('payments.amount') }}

                                </label>



                                <input type="number"
                                       step="0.01"
                                       name="amount"
                                       id="amount"
                                       class="form-control rounded-3"
                                       min="0.01"
                                       required>


                            </div>







                            <div class="col-md-4">


                                <label class="form-label fw-semibold">

                                    {{ __('payments.method') }}

                                </label>



                                <select name="method"
                                        class="form-select rounded-3">


                                    <option value="كاش">

                                        {{ __('payments.cash') }}

                                    </option>


                                    <option value="تحويل">

                                        {{ __('payments.transfer') }}

                                    </option>


                                </select>


                            </div>







                            <div class="col-md-4">


                                <label class="form-label fw-semibold">

                                    {{ __('payments.note') }}

                                </label>



                                <input type="text"
                                       name="note"
                                       class="form-control rounded-3">


                            </div>



                        </div>



                    </div>


                </div>









                <div class="text-end">


                    <a href="{{ route('payments.index') }}"
                       class="btn btn-outline-secondary px-4">


                        {{ __('payments.cancel') }}


                    </a>





                    <button type="submit"
                            class="btn btn-success px-5">


                        <i class="bi bi-save me-1"></i>

                        {{ __('payments.save') }}


                    </button>


                </div>





            </form>


        </div>



    </div>



</div>







<script>


document.addEventListener('DOMContentLoaded',()=>{


    const sale =
        document.getElementById('sale_id');


    const remaining =
        document.getElementById('remaining');



    sale.addEventListener('change',()=>{


        let option =
            sale.options[sale.selectedIndex];



        remaining.value =
            option.dataset.remaining
            ?
            Number(option.dataset.remaining).toFixed(2)
            :
            '';



    });



});



</script>



@endsection