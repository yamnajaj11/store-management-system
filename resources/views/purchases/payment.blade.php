@extends('layouts.app')

@section('title', __('purchases.add_payment'))

@section('content')

    <div class="container-fluid">

        <div class="bg-white p-4 shadow-sm rounded-3">


            <h4 class="mb-4">

                <i class="bi bi-cash text-success me-2"></i>

                {{ __('purchases.add_payment') }}

            </h4>





            <div class="alert alert-info">


                {{ __('purchases.invoice_number') }}:

                <strong>
                    {{ $purchase->invoice_number }}
                </strong>


                <br>




                {{ __('purchases.supplier') }}:

                <strong>
                    {{ $purchase->supplier->name }}
                </strong>


                <br>




                {{ __('purchases.invoice_total') }}:

                <strong>
                    {{ formatAmount($purchase->total_amount) }}
                </strong>


                <br>




                {{ __('purchases.paid_amount') }}:

                <strong>
                    {{ formatAmount($purchase->paid_amount) }}
                </strong>


                <br>




                {{ __('purchases.remaining_amount') }}:

                <strong>
                    {{ formatAmount($purchase->remaining_amount) }}
                </strong>


            </div>








            <form method="POST" action="{{ route('purchases.payment.store', $purchase->id) }}">

                @csrf




                <div class="mb-3">


                    <label class="form-label">

                        {{ __('purchases.payment_amount') }}

                    </label>




                    <input type="number" step="0.01" name="amount" class="form-control"
                        placeholder="{{ __('purchases.enter_payment_amount') }}" required>


                </div>







                <div class="text-end">


                    <button class="btn btn-success">

                        <i class="bi bi-check-circle me-1"></i>

                        {{ __('purchases.save_payment') }}

                    </button>





                    <a href="{{ route('purchases.index') }}" class="btn btn-secondary">

                        <i class="bi bi-arrow-left me-1"></i>

                        {{ __('purchases.back') }}

                    </a>


                </div>



            </form>



        </div>

    </div>


@endsection