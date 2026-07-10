@extends('layouts.app')

@section('title', __('customers.customers'))

@section('content')
<div class="container-fluid">
    <div class="bg-white p-4 shadow-sm rounded-3">

        <!-- العنوان وشريط الأدوات -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">
                <i class="bi bi-people text-primary me-2"></i> {{ __('customers.customers') }}
            </h4>
            <a href="{{ route('customers.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> {{ __('customers.add_customer') }}
            </a>
        </div>

        <!-- نموذج البحث -->
        <form method="GET" action="{{ route('customers.index') }}" class="row g-2 mb-3">
            <div class="col-md-4">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control" placeholder="{{ __('customers.search_by_name_or_phone') }}">
            </div>

            <div class="col-md-3">
                <select name="has_sales" class="form-select">
                    <option value="">{{ __('customers.all_customers') }}</option>
                    <option value="1" {{ request('has_sales') == '1' ? 'selected' : '' }}>
                        {{ __('customers.has_sales_only') }}
                    </option>
                </select>
            </div>

            <div class="col-md-2">
                <button type="submit" class="btn btn-dark w-100">
                    <i class="bi bi-search"></i> {{ __('customers.search') }}
                </button>
            </div>
        </form>

        <!-- جدول العملاء -->
        <div class="table-responsive">
            <table class="table table-hover text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>{{ __('customers.name') }}</th>
                        <th>{{ __('customers.phone') }}</th>
                        <th>{{ __('customers.address') }}</th>
                        <th>{{ __('customers.sales_count') }}</th>
                        <th>{{ __('customers.total_sales') }}</th> 
                        <th>{{ __('customers.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                        <tr>
                            <td>{{ $customer->id }}</td>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->phone ?? '-' }}</td>
                            <td>{{ $customer->address ?? '-' }}</td>
                            <td>{{ $customer->sales->count() }}</td>
                            <td>{{ number_format($customer->sales_sum_total_amount, 2) }} {{ __('customers.currency_symbol') }}</td> <!-- ✅ جديد -->


                            <td>
                                <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="d-inline">
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
                            <td colspan="6" class="text-muted">{{ __('customers.no_customers_found') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- ترقيم الصفحات -->
        <div class="d-flex justify-content-center mt-3">
            {{ $customers->links() }}
        </div>
    </div>
</div>
@endsection
