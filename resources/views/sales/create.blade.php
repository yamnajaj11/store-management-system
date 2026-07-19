@extends('layouts.app')

@section('title', __('sales.add'))

@section('content')

    <div class="container-fluid">

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">


            <div class="card-header bg-white border-0 p-4">

                <div class="d-flex align-items-center">

                    <div class="bg-primary-subtle rounded-3 p-3 me-3">
                        <i class="bi bi-cart-plus fs-3 text-primary"></i>
                    </div>


                    <div>

                        <h4 class="mb-1 fw-bold">
                            {{ __('sales.add') }}
                        </h4>


                        <small class="text-muted">
                            {{ __('sales.create_invoice_description') }}
                        </small>

                    </div>

                </div>

            </div>



            <div class="card-body p-4">


                @if(session('error'))

                    <div class="alert alert-danger alert-dismissible fade show shadow-sm">

                        <i class="bi bi-exclamation-triangle me-2"></i>

                        {{ session('error') }}

                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

                    </div>

                @endif



                @if($errors->any())

                    <div class="alert alert-danger">

                        <ul class="mb-0">

                            @foreach($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                @endif



                <form action="{{ route('sales.store') }}" method="POST">

                    @csrf




                    {{-- معلومات الفاتورة --}}

                    <div class="card border-0 bg-light rounded-4 mb-4">


                        <div class="card-body">


                            <h5 class="mb-3">

                                <i class="bi bi-info-circle text-primary me-2"></i>

                                {{ __('sales.invoice_information') }}

                            </h5>




                            <div class="row g-3">



                                <div class="col-md-4">


                                    <label class="form-label fw-semibold">
                                        {{ __('sales.customer') }}
                                    </label>


                                    <select name="customer_id" class="form-select rounded-3" required>


                                        <option value="">
                                            {{ __('sales.select_customer') }}
                                        </option>



                                        @foreach($customers as $customer)

                                            <option value="{{ $customer->id }}">

                                                {{ $customer->name }}

                                            </option>

                                        @endforeach


                                    </select>


                                </div>





                                <div class="col-md-3">


                                    <label class="form-label fw-semibold">
                                        {{ __('sales.date') }}
                                    </label>


                                    <input type="date" name="sale_date" class="form-control rounded-3"
                                        value="{{ now()->format('Y-m-d') }}" required>


                                </div>





                                <div class="col-md-2">


                                    <label class="form-label fw-semibold">
                                        {{ __('sales.status') }}
                                    </label>


                                    <select name="status" class="form-select rounded-3" required>


                                        <option value="مدفوع">
                                            {{ __('sales.paid') }}
                                        </option>


                                        <option value="مدفوع جزئي">
                                            {{ __('sales.partial_paid') }}
                                        </option>


                                        <option value="غير مدفوع" selected>
                                            {{ __('sales.unpaid') }}
                                        </option>


                                    </select>


                                </div>





                                <div class="col-md-2">


                                    <label class="form-label fw-semibold">
                                        {{ __('sales.discount') }}
                                    </label>



                                    <input type="number" name="discount" id="invoiceDiscount" class="form-control" value="0"
                                        min="0" max="100">


                                </div>






                                {{-- مبلغ الدفع --}}

                                <div class="col-md-3" id="paymentBox" style="display:none">


                                    <label class="form-label fw-semibold">

                                        مبلغ الدفعة

                                    </label>



                                    <input type="number" name="paid_amount" id="paymentAmount" class="form-control"
                                        value="0" min="0" step="0.01">



                                    <small class="text-muted">

                                        طريقة الدفع: كاش

                                    </small>


                                </div>




                            </div>


                        </div>


                    </div>






                    {{-- المنتجات --}}


                    <div class="card border rounded-4 mb-4">


                        <div class="card-header bg-light">


                            <div class="d-flex justify-content-between align-items-center">


                                <h6 class="mb-0 fw-bold">

                                    <i class="bi bi-box-seam text-primary me-2"></i>

                                    {{ __('sales.items') }}

                                </h6>



                                <button type="button" id="addItem" class="btn btn-outline-primary btn-sm">


                                    <i class="bi bi-plus-circle me-1"></i>

                                    {{ __('sales.add_item') }}


                                </button>


                            </div>


                        </div>





                        <div class="card-body">


                            <div class="table-responsive">


                                <table class="table table-bordered text-center align-middle">


                                    <thead class="table-light">


                                        <tr>


                                            <th>
                                                {{ __('sales.product') }}
                                            </th>


                                            <th>
                                                {{ __('sales.stock') }}
                                            </th>


                                            <th>
                                                {{ __('sales.quantity') }}
                                            </th>


                                            <th>
                                                {{ __('sales.price') }}
                                            </th>


                                            <th>
                                                {{ __('sales.discount') }}
                                            </th>


                                            <th>
                                                {{ __('sales.subtotal') }}
                                            </th>


                                            <th>
                                                {{ __('sales.actions') }}
                                            </th>


                                        </tr>


                                    </thead>



                                    <tbody id="itemsBody">


                                        <tr>


                                            <td>


                                                <select name="items[0][product_id]" class="form-select product-select"
                                                    required>


                                                    <option value="">
                                                        {{ __('sales.select_product') }}
                                                    </option>



                                                    @foreach($products as $product)


                                                        <option value="{{ $product->id }}"
                                                            data-price="{{ $product->selling_price }}"
                                                            data-stock="{{ $product->stock }}">


                                                            {{ $product->name }}


                                                        </option>


                                                    @endforeach



                                                </select>


                                            </td>


                                            <td>

                                                <input type="text" class="form-control stock" readonly>

                                            </td>




                                            <td>

                                                <input type="number" name="items[0][quantity]" class="form-control quantity"
                                                    value="1" min="1" required>

                                            </td>





                                            <td>

                                                <input type="number" step="0.01" name="items[0][unit_price]"
                                                    class="form-control price" readonly required>

                                            </td>





                                            <td>

                                                <input type="number" name="items[0][discount]" class="form-control discount"
                                                    value="0" min="0" max="100">

                                            </td>





                                            <td>

                                                <input type="text" class="form-control subtotal" value="0.00" readonly>

                                            </td>





                                            <td>

                                                <button type="button" class="btn btn-outline-danger btn-sm remove-item">


                                                    <i class="bi bi-trash"></i>


                                                </button>

                                            </td>


                                        </tr>


                                    </tbody>


                                </table>


                            </div>


                        </div>


                    </div>
                    {{-- الإجماليات --}}

                    <div class="card border-0 bg-light rounded-4 mb-4">

                        <div class="card-body text-end">


                            <div class="mb-2">

                                {{ __('sales.subtotal') }}

                                :

                                <span id="beforeDiscount" class="fw-bold">
                                    0.00
                                </span>

                                {{ __('sales.currency') }}

                            </div>




                            <div class="mb-2 text-danger">

                                {{ __('sales.items_discount') }}

                                :

                                <span id="itemsDiscount" class="fw-bold">
                                    0.00
                                </span>

                                {{ __('sales.currency') }}

                            </div>




                            <div class="mb-2 text-danger">

                                {{ __('sales.invoice_discount') }}

                                :

                                <span id="invoiceDiscountAmount" class="fw-bold">
                                    0.00
                                </span>

                                {{ __('sales.currency') }}

                            </div>




                            <hr>



                            <h4 class="fw-bold">

                                {{ __('sales.total') }}

                                :

                                <span id="totalAmount" class="text-primary">
                                    0.00
                                </span>

                                {{ __('sales.currency') }}

                            </h4>


                        </div>

                    </div>





                    <div class="text-end">


                        <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary px-4">

                            {{ __('sales.cancel') }}

                        </a>




                        <button type="submit" class="btn btn-success px-5">

                            <i class="bi bi-check-circle me-1"></i>

                            {{ __('sales.save') }}

                        </button>


                    </div>


                </form>


            </div>


        </div>


    </div>





    <script>

        document.addEventListener('DOMContentLoaded', function () {


            let itemIndex = 1;


            const body =
                document.getElementById('itemsBody');


            const total =
                document.getElementById('totalAmount');


            const beforeDiscount =
                document.getElementById('beforeDiscount');


            const itemsDiscount =
                document.getElementById('itemsDiscount');


            const invoiceDiscount =
                document.getElementById('invoiceDiscount');


            const invoiceDiscountAmount =
                document.getElementById('invoiceDiscountAmount');


            const status =
                document.querySelector('select[name="status"]');


            const paymentBox =
                document.getElementById('paymentBox');


            const paymentAmount =
                document.getElementById('paymentAmount');






            function formatNumber(value) {

                return Number(value || 0).toFixed(2);

            }







            function updatePayment() {


                if (status.value === 'مدفوع') {


                    paymentBox.style.display = 'block';


                    paymentAmount.value =
                        total.innerText;


                }



                else if (status.value === 'مدفوع جزئي') {


                    paymentBox.style.display = 'block';


                }



                else {


                    paymentBox.style.display = 'none';


                    paymentAmount.value = 0;


                }


            }








            function calculate() {


                let subtotalTotal = 0;

                let discountTotal = 0;



                document.querySelectorAll('#itemsBody tr')
                    .forEach(row => {



                        let qty =
                            Number(
                                row.querySelector('.quantity').value
                            ) || 0;



                        let price =
                            Number(
                                row.querySelector('.price').value
                            ) || 0;



                        let discount =
                            Number(
                                row.querySelector('.discount').value
                            ) || 0;




                        let subtotal =
                            qty * price;



                        let discountValue =
                            subtotal * discount / 100;



                        let final =
                            subtotal - discountValue;




                        row.querySelector('.subtotal').value =
                            formatNumber(final);



                        subtotalTotal += subtotal;


                        discountTotal += discountValue;



                    });




                let afterItems =
                    subtotalTotal - discountTotal;



                let invoiceValue =
                    afterItems *
                    (Number(invoiceDiscount.value) || 0)
                    /
                    100;




                let finalTotal =
                    afterItems - invoiceValue;





                beforeDiscount.innerText =
                    formatNumber(subtotalTotal);



                itemsDiscount.innerText =
                    formatNumber(discountTotal);



                invoiceDiscountAmount.innerText =
                    formatNumber(invoiceValue);



                total.innerText =
                    formatNumber(finalTotal);




                if (status.value === 'مدفوع') {


                    paymentAmount.value =
                        formatNumber(finalTotal);


                }



            }








            function setProductData(select) {


                let option =
                    select.options[select.selectedIndex];


                let row =
                    select.closest('tr');



                row.querySelector('.price').value =
                    option.dataset.price ?? '';



                row.querySelector('.stock').value =
                    option.dataset.stock ?? 0;



                calculate();


            }








            document.querySelectorAll('.product-select')
                .forEach(select => {


                    select.addEventListener('change', function () {

                        setProductData(this);

                    });


                });








            document.getElementById('addItem')
                .addEventListener('click', function () {



                    let row =
                        document.createElement('tr');



                    row.innerHTML = `


    <td>

    <select name="items[${itemIndex}][product_id]"
    class="form-select product-select"
    required>


    <option value="">
    {{ __('sales.select_product') }}
    </option>



    @foreach($products as $product)

        <option value="{{ $product->id }}"

        data-price="{{ $product->selling_price }}"

        data-stock="{{ $product->stock }}">

        {{ $product->name }}

        </option>


    @endforeach


    </select>


    </td>





    <td>

    <input class="form-control stock"
    readonly>

    </td>





    <td>

    <input type="number"

    name="items[${itemIndex}][quantity]"

    class="form-control quantity"

    value="1"

    min="1"

    required>

    </td>





    <td>

    <input type="number"

    step="0.01"

    name="items[${itemIndex}][unit_price]"

    class="form-control price"

    readonly>

    </td>





    <td>

    <input type="number"

    name="items[${itemIndex}][discount]"

    class="form-control discount"

    value="0">

    </td>





    <td>

    <input class="form-control subtotal"

    value="0.00"

    readonly>

    </td>





    <td>

    <button type="button"

    class="btn btn-outline-danger remove-item">

    <i class="bi bi-trash"></i>

    </button>

    </td>



    `;



                    body.appendChild(row);




                    row.querySelector('.product-select')
                        .addEventListener('change', function () {

                            setProductData(this);

                        });



                    itemIndex++;



                });








            body.addEventListener('input', calculate);


            invoiceDiscount.addEventListener('input', calculate);


            status.addEventListener('change', updatePayment);








            body.addEventListener('click', function (e) {


                if (e.target.closest('.remove-item')) {


                    e.target.closest('tr').remove();


                    calculate();


                }


            });



            calculate();



        });


    </script>


@endsection