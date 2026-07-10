@extends('layouts.app')

@section('title', __('products.products'))

@section('content')
<div class="container-fluid">
    <div class="bg-white p-4 shadow-sm rounded-3">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">
                <i class="bi bi-box-seam text-primary me-2"></i> {{ __('products.products') }}
            </h4>
            <a href="{{ route('products.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> {{ __('products.add_product') }}
            </a>
        </div>

        <form method="GET" action="{{ route('products.index') }}" class="row g-2 mb-3">
            <div class="col-md-4">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control" placeholder="{{ __('products.search_by_name') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-dark w-100">
                    <i class="bi bi-search"></i> {{ __('products.search') }}
                </button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>{{ __('products.name') }}</th>
                        <th>{{ __('products.barcode') }}</th>
                        <th>{{ __('products.unit') }}</th>
                        <th>{{ __('products.purchase_price') }}</th>
                        <th>{{ __('products.selling_price') }}</th>
                        <th>{{ __('products.stock') }}</th>
                        <th>{{ __('products.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->barcode ?? '-' }}</td>
                            <td>{{ $product->unit ?? '-' }}</td>

                            <td>{{ (int) $product->purchase_price }}</td>
                            <td>{{ (int) $product->selling_price }}</td>

                            <td>{{ $product->stock }}</td>
                            <td>
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('هل أنت متأكد من حذف هذا المنتج؟')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-muted">{{ __('products.no_products_found') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
