@extends('layouts.app')

@section('title', __('payments.create_title'))

@section('content')
<div class="container-fluid">
    <div class="bg-white p-4 shadow-sm rounded-3">

        <h4 class="mb-4"><i class="bi bi-plus-circle text-success me-2"></i> {{ __('payments.create_title') }}</h4>

        <form action="{{ route('payments.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="sale_id" class="form-label">{{ __('payments.sale_id') }}</label>
                <input type="number" name="sale_id" id="sale_id" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="amount" class="form-label">{{ __('payments.amount') }}</label>
                <input type="number" step="0.01" name="amount" id="amount" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="payment_date" class="form-label">{{ __('payments.payment_date') }}</label>
                <input type="date" name="payment_date" id="payment_date" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">{{ __('payments.save') }}</button>
            <a href="{{ route('payments.index') }}" class="btn btn-secondary">{{ __('payments.cancel') }}</a>
        </form>
    </div>
</div>
@endsection
