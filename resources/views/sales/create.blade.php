@extends('layouts.app')

@section('title', __('sales.add'))

@section('content')
<div class="container-fluid">
    <div class="bg-white p-4 shadow-sm rounded-3">
        <h4 class="mb-4"><i class="bi bi-plus-circle me-2 text-primary"></i> {{ __('sales.add') }}</h4>

        <form action="{{ route('sales.store') }}" method="POST" id="saleForm">
            @csrf

            <!-- اختيار العميل -->
            <div class="mb-3">
                <label class="form-label">{{ __('sales.customer') }}</label>
                <select name="customer_id" class="form-select" required>
                    <option value="">{{ __('sales.select_customer') }}</option>
                    @foreach(\App\Models\Customer::all() as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- تاريخ البيع -->
            <div class="mb-3">
                <label class="form-label">{{ __('sales.date') }}</label>
                <input type="date" name="sale_date" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
            </div>

            <!-- حالة الفاتورة -->
            <div class="mb-3">
                <label class="form-label">{{ __('sales.status') }}</label>
                <select name="status" class="form-select" required>
                    <option value="مدفوع">مدفوع</option>
                    <option value="مدفوع جزئي">مدفوع جزئي</option>
                    <option value="غير مدفوع" selected>غير مدفوع</option>
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
                    <tr>
                        <td>
                            <select name="items[0][product_id]" class="form-select" required>
                                <option value="">{{ __('sales.select_product') }}</option>
                                @foreach(\App\Models\Product::all() as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="number" name="items[0][quantity]" class="form-control quantity" min="1" value="1" required></td>
                        <td><input type="number" step="0.01" name="items[0][price]" class="form-control price" required></td>
                        <td class="subtotal">0.00</td>
                        <td><button type="button" class="btn btn-sm btn-danger remove-item"><i class="bi bi-x-lg"></i></button></td>
                    </tr>
                </tbody>
            </table>

            <div class="text-end mb-3">
                <button type="button" class="btn btn-outline-primary" id="addItem"><i class="bi bi-plus-lg"></i> {{ __('sales.add_item') }}</button>
            </div>

            <!-- المجموع الكلي -->
            <div class="text-end">
                <h5>{{ __('sales.total') }}: <span id="totalAmount">0.00</span> {{ __('sales.currency') }}</h5>
            </div>

            <div class="mt-4 text-center">
                <button type="submit" class="btn btn-success px-4">{{ __('sales.save') }}</button>
                <a href="{{ route('sales.index') }}" class="btn btn-secondary px-4">{{ __('sales.cancel') }}</a>
            </div>
        </form>
    </div>
</div>

<!-- سكربت لحساب الإجمالي -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    let itemIndex = 1;

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

    // إضافة صف جديد
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

    // حذف صف
    itemsBody.addEventListener('click', e => {
        if (e.target.closest('.remove-item')) {
            e.target.closest('tr').remove();
            calculateTotals();
        }
    });

    // تحديث المجموع عند التغيير
    itemsBody.addEventListener('input', calculateTotals);
});
</script>
@endsection
