@extends('layouts.app')

@section('title', __('products.add_product'))

@section('content')
<div class="container-fluid">
    <div class="bg-white p-4 shadow-sm rounded-4 border">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 text-primary fw-bold">
                <i class="bi bi-box-seam me-2"></i> {{ __('products.add_product') }}
            </h4>
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> {{ __('products.back') }}
            </a>
        </div>

        <form action="{{ route('products.store') }}" method="POST" class="needs-validation" novalidate>
            @csrf
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-body">
                            <h5 class="card-title mb-3 text-secondary">
                                <i class="bi bi-info-circle me-2"></i> {{ __('products.product_details') }}
                            </h5>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">{{ __('products.name') }}</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="{{ __('products.name') }}" required>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">{{ __('products.purchase_price') }}</label>
                                    <input type="number" name="purchase_price" class="form-control" value="{{ old('purchase_price') }}" required>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">{{ __('products.selling_price') }}</label>
                                    <input type="number" name="selling_price" class="form-control" value="{{ old('selling_price') }}" required>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">{{ __('products.stock') }}</label>
                                    <input type="number" name="stock" class="form-control" value="{{ old('stock') }}" required>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">{{ __('products.unit') }}</label>
                                    <input type="text" name="unit" class="form-control" value="{{ old('unit') }}" required>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">{{ __('products.barcode') }}</label>
                                    <input type="text" name="barcode" class="form-control" value="{{ old('barcode') }}">
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">{{ __('products.supplier') }}</label>
                                    <select name="supplier_id" class="form-select">
                                        <option value="">— {{ __('products.optional') }} —</option>
                                        @foreach(App\Models\Supplier::all() as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold">{{ __('products.description') }}</label>
                                    <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-3 bg-light">
                        <div class="card-body">
                            <h6 class="text-secondary fw-bold mb-3">
                                <i class="bi bi-lightbulb"></i> {{ __('products.tips') }}
                            </h6>
                            <ul class="small text-muted ps-3">
                                <li>{{ __('products.tip_unique_name') }}</li>
                                <li>{{ __('products.tip_price_accuracy') }}</li>
                                <li>{{ __('products.tip_barcode_optional') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-success px-4">
                    <i class="bi bi-check-circle me-1"></i> {{ __('products.save') }}
                </button>
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary px-4">
                    <i class="bi bi-x-circle me-1"></i> {{ __('products.cancel') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
