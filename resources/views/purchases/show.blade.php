@extends('layouts.app')

@section('title', __('purchases.purchase_details'))

@section('content')
<div class="container-fluid">
    <div class="bg-white p-4 shadow-sm rounded-3">
        <div class="d-flex justify-content-between mb-3">
            <h4><i class="bi bi-info-circle me-2"></i> {{ __('purchases.purchase_details') }}</h4>
            <a href="{{ route('purchases.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-right"></i> {{ __('purchases.back') }}
            </a>
        </div>

        <ul class="list-group">
            <li class="list-group-item"><strong>{{ __('purchases.product') }}:</strong> {{ $purchase->product->name ?? '-' }}</li>
            <li class="list-group-item"><strong>{{ __('purchases.supplier') }}:</strong> {{ $purchase->supplier->name ?? '-' }}</li>
            <li class="list-group-item"><strong>{{ __('purchases.quantity') }}:</strong> {{ $purchase->quantity }}</li>
            <li class="list-group-item"><strong>{{ __('purchases.price') }}:</strong> {{ number_format($purchase->price, 2) }}</li>
            <li class="list-group-item"><strong>{{ __('purchases.purchased_at') }}:</strong> {{ $purchase->purchased_at }}</li>
        </ul>
    </div>
</div>
@endsection
