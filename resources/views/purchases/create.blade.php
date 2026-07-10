@extends('layouts.app')

@section('title', __('purchases.add_purchase'))

@section('content')
<div class="container-fluid">
    <div class="bg-white p-4 shadow-sm rounded-3">
        <h4 class="mb-3"><i class="bi bi-plus-square me-2"></i> {{ __('purchases.add_purchase') }}</h4>

        <form action="{{ route('purchases.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">{{ __('purchases.product') }}</label>
                <select name="product_id" class="form-select" required>
                    <option value="">{{ __('purchases.product') }}</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('purchases.supplier') }}</label>
                <select name="supplier_id" class="form-select" required>
                    <option value="">{{ __('purchases.supplier') }}</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('purchases.quantity') }}</label>
                <input type="number" name="quantity" class="form-control" min="1" required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('purchases.price') }}</label>
                <input type="number" step="0.01" name="price" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('purchases.purchased_at') }}</label>
                <input type="date" name="purchased_at" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">{{ __('purchases.save') }}</button>
            <a href="{{ route('purchases.index') }}" class="btn btn-secondary">{{ __('purchases.cancel') }}</a>
        </form>
    </div>
</div>
@endsection
