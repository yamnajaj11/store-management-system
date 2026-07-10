@extends('layouts.app')

@section('title', __('suppliers.suppliers'))

@section('content')
<div class="container-fluid">
    <div class="bg-white p-4 shadow-sm rounded-3">

        <!-- العنوان وزر الإضافة -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">
                <i class="bi bi-truck text-primary me-2"></i> {{ __('suppliers.suppliers') }}
            </h4>
            <a href="{{ route('suppliers.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> {{ __('suppliers.add_supplier') }}
            </a>
        </div>

        <!-- جدول الموردين -->
        <div class="table-responsive">
            <table class="table table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>{{ __('suppliers.name') }}</th>
                        <th>{{ __('suppliers.company') }}</th>
                        <th>{{ __('suppliers.phone') }}</th>
                        <th>{{ __('suppliers.address') }}</th>
                        <th>{{ __('suppliers.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers as $supplier)
                        <tr>
                            <td>{{ $supplier->id }}</td>
                            <td>{{ $supplier->name }}</td>
                            <td>{{ $supplier->company ?? '—' }}</td>
                            <td>{{ $supplier->phone ?? '—' }}</td>
                            <td>{{ $supplier->address ?? '—' }}</td>
                            <td>
                                <a href="{{ route('suppliers.show', $supplier->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('هل أنت متأكد من حذف هذا المنتج ؟')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-muted">{{ __('suppliers.no_suppliers_found') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection
