@extends('layouts.app')

@section('title', __('purchases.edit_purchase'))

@section('content')
<div class="container-fluid">
    <div class="bg-white p-4 shadow-sm rounded-3">
        <h4 class="mb-3"><i class="bi bi-pencil-square me-2"></i> {{ __('purchases.edit_purchase') }}</h4>

        <form action="{{ route('purchases.update', $purchase->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">{{ __('purchases.product') }}</label>
                <select name="product_id" class="form-select" required>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ $purchase->product_id == $product->id ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('purchases.supplier') }}</label>
                <select name="supplier_id" class="form-select" required>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ $purchase->supplier_id == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('purchases.quantity') }}</label>
                <input type="number" name="quantity" class="form-control" value="{{ $purchase->quantity }}" min="1" required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('purchases.price') }}</label>
                <input type="number" step="0.01" name="price" class="form-control" value="{{ $purchase->price }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('purchases.purchased_at') }}</label>
                <input type="date" name="purchased_at" class="form-control"
                       value="{{ \Carbon\Carbon::parse($purchase->purchased_at)->format('Y-m-d') }}" required>
            </div>

            <button type="submit" class="btn btn-primary">{{ __('purchases.save') }}</button>
            <a href="{{ route('purchases.index') }}" class="btn btn-secondary">{{ __('purchases.cancel') }}</a>
        </form>
    </div>
</div>
@endsection
