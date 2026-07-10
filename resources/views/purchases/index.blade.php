@extends('layouts.app')

@section('title', __('purchases.purchases'))

@section('content')
<div class="container-fluid">
    <div class="bg-white p-4 shadow-sm rounded-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">
                <i class="bi bi-bag-check text-primary me-2"></i> {{ __('purchases.purchases') }}
            </h4>
            <a href="{{ route('purchases.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> {{ __('purchases.add_purchase') }}
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>{{ __('purchases.product') }}</th>
                        <th>{{ __('purchases.supplier') }}</th>
                        <th>{{ __('purchases.quantity') }}</th>
                        <th>{{ __('purchases.price') }}</th>
                        <th>{{ __('purchases.purchased_at') }}</th>
                        <th>{{ __('purchases.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($purchases as $purchase)
                        <tr>
                            <td>{{ $purchase->id }}</td>
                            <td>{{ $purchase->product->name ?? '-' }}</td>
                            <td>{{ $purchase->supplier->name ?? '-' }}</td>
                            <td>{{ $purchase->quantity }}</td>
                            <td>{{ number_format($purchase->price, 2) }}</td>
                            <td>{{ $purchase->purchased_at }}</td>
                            <td>
                                <a href="{{ route('purchases.edit', $purchase->id) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('purchases.destroy', $purchase->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" onclick="return confirm('هل أنت متأكد من حذف هذا العميل؟')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-muted">{{ __('purchases.no_purchases') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
