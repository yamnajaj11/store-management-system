@extends('layouts.app')

@section('title', __('products.product_details'))

@section('content')
<div class="container-fluid">
    <div class="bg-white p-4 shadow-sm rounded-3">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">
                <i class="bi bi-box-seam me-2 text-primary"></i>
                {{ __('products.product_details') }}
            </h4>

            <div>
                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil-square"></i> {{ __('products.edit') }}
                </a>
                <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-right-circle"></i> {{ __('products.back') }}
                </a>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="p-3 border rounded bg-light">
                    <h6 class="text-muted">{{ __('products.name') }}</h6>
                    <p class="fs-5 fw-semibold mb-0">{{ $product->name }}</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-3 border rounded bg-light">
                    <h6 class="text-muted">{{ __('products.purchase_price') }}</h6>
                    <p class="fs-5 fw-semibold mb-0">{{ (int) $product->purchase_price }}</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-3 border rounded bg-light">
                    <h6 class="text-muted">{{ __('products.selling_price') }}</h6>
                    <p class="fs-5 fw-semibold mb-0">{{ (int) $product->selling_price }}</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-3 border rounded bg-success bg-opacity-10">
                    <h6 class="text-muted">
                        <i class="bi bi-graph-up-arrow text-success me-1"></i>
                        {{ __('products.profit_per_unit') }}
                    </h6>
                    <p class="fs-5 fw-bold text-success mb-0">
                        {{ (int) ($product->selling_price - $product->purchase_price) }}
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-3 border rounded bg-light">
                    <h6 class="text-muted">{{ __('products.stock') }}</h6>
                    <p class="fs-5 fw-semibold mb-0">{{ (int) $product->stock }}</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-3 border rounded bg-light">
                    <h6 class="text-muted">{{ __('products.unit') }}</h6>
                    <p class="fs-5 fw-semibold mb-0">{{ $product->unit ?? '—' }}</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="p-3 border rounded bg-light">
                    <h6 class="text-muted">{{ __('products.barcode') }}</h6>
                    <p class="fs-5 fw-semibold mb-0">{{ $product->barcode ?? '—' }}</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="p-3 border rounded bg-light">
                    <h6 class="text-muted">{{ __('products.supplier') }}</h6>
                    <p class="fs-5 fw-semibold mb-0">
                        {{ $product->supplier ? $product->supplier->name : '—' }}
                    </p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="p-3 border rounded bg-light">
                    <h6 class="text-muted">{{ __('products.description') }}</h6>
                    <p class="mb-0">{{ $product->description ?? '—' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
