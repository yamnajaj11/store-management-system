@extends('layouts.app')

@section('title', __('sales.edit'))

@section('content')
<div class="container-fluid">
    <div class="bg-white p-4 shadow-sm rounded-3">
        <h4 class="mb-4"><i class="bi bi-pencil-square me-2 text-warning"></i> {{ __('sales.edit') }}</h4>

        <form action="{{ route('sales.update', $sale->id) }}" method="POST" id="saleForm">
            @csrf
            @method('PUT')

            <!-- اختيار العميل -->
            <div class="mb-3">
                <label class="form-label">{{ __('sales.customer') }}</label>
                <select name="customer_id" class="form-select" required>
                    <option value="">{{ __('sales.select_customer') }}</option>
                    @foreach(\App\Models\Customer::all() as $customer)
                        <option value="{{ $customer->id }}" {{ $sale->customer_id == $customer->id ? 'selected' : '' }}>
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- تاريخ البيع -->
            <div class="mb-3">
                <label class="form-label">{{ __('sales.date') }}</label>
                <input type="date" name="sale_date" class="form-control" value="{{ \Carbon\Carbon::parse($sale->sale_date)->format('Y-m-d') }}" required>
            </div>

            <!-- الحالة -->
            <div class="mb-3">
                <label class="form-label">{{ __('sales.status') }}</label>
                <select name="status" class="form-select" required>
                    <option value="مدفوع" {{ $sale->status == 'مدفوع' ? 'selected' : '' }}>مدفوع</option>
                    <option value="مدفوع جزئي" {{ $sale->status == 'مدفوع جزئي' ? 'selected' : '' }}>مدفوع جزئي</option>
                    <option value="غير مدفوع" {{ $sale->status == 'غير مدفوع' ? 'selected' : '' }}>غير مدفوع</option>
                </select>
            </div>

            <!-- عناصر الفاتورة -->
            <h5 class="mt-4 mb-3"><i class="bi bi-bag-check me-2"></i> {{ __('sales.items') }}</h5>
            <table class="table table-bordered align-middle text-center" id="itemsTable">
                <thead class="table-light">
                    <tr>
                        <th>{{ __('sales.product') }}</th>
                        <th>{{ __('sales.quantity') }}</th>
                        <th>{{ __('sales.price') }}</th>
                        <th>{{ __('sales.subtotal') }}</th>
                        <th>{{ __('sales.actions') }}</th>
                    </tr>
                </thead>
                <tbody id="itemsBody">
                    @foreach($sale->items as $index => $item)
                        <tr>
                            <td>
                                <select name="items[{{ $index }}][product_id]" class="form-select" required>
                                    <option value="">{{ __('sales.select_product') }}</option>
                                    @foreach(\App\Models\Product::all() as $product)
                                        <option value="{{ $product->id }}" {{ $item->product_id == $product->id ? 'selected' : '' }}>
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="number" name="items[{{ $index }}][quantity]" class="form-control quantity" min="1" value="{{ $item->quantity }}" required></td>
                            <td><input type="number" step="0.01" name="items[{{ $index }}][price]" class="form-control price" value="{{ $item->price }}" required></td>
                            <td class="subtotal">{{ number_format($item->quantity * $item->price, 2) }}</td>
                            <td><button type="button" class="btn btn-sm btn-danger remove-item"><i class="bi bi-x-lg"></i></button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-end mb-3">
                <button type="button" class="btn btn-outline-primary" id="addItem"><i class="bi bi-plus-lg"></i> {{ __('sales.add_item') }}</button>
            </div>

            <!-- المجموع الكلي -->
            <div class="text-end">
                <h5>{{ __('sales.total') }}: <span id="totalAmount">{{ number_format($sale->total_amount, 2) }}</span> {{ __('sales.currency') }}</h5>
            </div>

            <div class="mt-4 text-center">
                <button type="submit" class="btn btn-warning px-4">{{ __('sales.update') }}</button>
                <a href="{{ route('sales.index') }}" class="btn btn-secondary px-4">{{ __('sales.cancel') }}</a>
            </div>
        </form>
    </div>
</div>

<!-- سكربت لحساب الإجمالي -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    let itemIndex = {{ count($sale->items) }};
    const addItemButton = document.getElementById('addItem');
    const itemsBody = document.getElementById('itemsBody');
    const totalAmount = document.getElementById('totalAmount');

    function calculateTotals() {
        let total = 0;
        document.querySelectorAll('#itemsBody tr').forEach(row => {
            const qty = parseFloat(row.querySelector('.quantity')?.value || 0);
            const price = parseFloat(row.querySelector('.price')?.value || 0);
            const subtotal = qty * price;
            row.querySelector('.subtotal').textContent = subtotal.toFixed(2);
            total += subtotal;
        });
        totalAmount.textContent = total.toFixed(2);
    }

    addItemButton.addEventListener('click', () => {
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>
                <select name="items[${itemIndex}][product_id]" class="form-select" required>
                    <option value="">اختر المنتج</option>
                    @foreach(\App\Models\Product::all() as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" name="items[${itemIndex}][quantity]" class="form-control quantity" min="1" value="1" required></td>
            <td><input type="number" step="0.01" name="items[${itemIndex}][price]" class="form-control price" required></td>
            <td class="subtotal">0.00</td>
            <td><button type="button" class="btn btn-sm btn-danger remove-item"><i class="bi bi-x-lg"></i></button></td>
        `;
        itemsBody.appendChild(newRow);
        itemIndex++;
    });

    itemsBody.addEventListener('click', e => {
        if (e.target.closest('.remove-item')) {
            e.target.closest('tr').remove();
            calculateTotals();
        }
    });

    itemsBody.addEventListener('input', calculateTotals);
});
</script>
@endsection
