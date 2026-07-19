@extends('layouts.app')

@section('title', __('payments.edit_title'))

@section('content')

<div class="container-fluid">

    <div class="card border-0 shadow-sm rounded-4">


        <div class="card-header bg-white border-0 p-4">


            <h4 class="fw-bold mb-0">

                <i class="bi bi-pencil-square text-warning me-2"></i>

                {{ __('payments.edit_title') }}

            </h4>


        </div>





        <div class="card-body p-4">


            @if(session('error'))

            <div class="alert alert-danger">

                {{ session('error') }}

            </div>

            @endif






            @if($errors->any())

            <div class="alert alert-danger">

                <ul class="mb-0">

                    @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

            @endif







            <form action="{{ route('payments.update',$payment->id) }}" method="POST">


                @csrf

                @method('PUT')







                <div class="mb-3">


                    <label class="form-label fw-semibold">

                        {{ __('payments.sale') }}

                    </label>



                    <input type="text"
                    class="form-control"
                    value="#{{ $payment->sale->invoice_number ?? $payment->sale_id }}"
                    readonly>


                </div>








                <div class="mb-3">


                    <label class="form-label fw-semibold">

                        {{ __('payments.amount') }}

                    </label>



                    <input type="number"
                    step="0.01"
                    name="amount"
                    class="form-control"
                    value="{{ old('amount',$payment->amount) }}"
                    required>


                </div>









                <div class="mb-3">


                    <label class="form-label fw-semibold">

                        {{ __('payments.method') }}

                    </label>



                    <select name="method" class="form-select">


                        <option value="كاش"
                        @selected(old('method',$payment->method) == 'كاش')>

                            {{ __('payments.cash') }}

                        </option>




                        <option value="تحويل"
                        @selected(old('method',$payment->method) == 'تحويل')>

                            {{ __('payments.transfer') }}

                        </option>




                    </select>


                </div>









                <div class="mb-3">


                    <label class="form-label fw-semibold">

                        {{ __('payments.payment_date') }}

                    </label>



                    <input type="datetime-local"
                    name="payment_date"
                    class="form-control"
                    value="{{ old('payment_date',$payment->payment_date->format('Y-m-d\TH:i')) }}"
                    required>


                </div>









                <div class="mb-3">


                    <label class="form-label fw-semibold">

                        {{ __('payments.note') }}

                    </label>



                    <textarea
                    name="note"
                    class="form-control"
                    rows="3">{{ old('note',$payment->note) }}</textarea>


                </div>









                <div class="text-end">


                    <a href="{{ route('payments.index') }}"
                    class="btn btn-secondary">


                        {{ __('payments.cancel') }}


                    </a>





                    <button class="btn btn-warning px-4">


                        <i class="bi bi-save me-1"></i>


                        {{ __('payments.update') }}


                    </button>


                </div>




            </form>



        </div>


    </div>


</div>


@endsection