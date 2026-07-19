@extends('layouts.app')

@section('title', __('purchases.create_new'))

@section('content')

    <div class="container-fluid">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body p-4">


                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>

                        <h4 class="fw-bold mb-1">

                            <i class="bi bi-cart-plus text-success me-2"></i>

                            {{ __('purchases.create_new') }}

                        </h4>


                        <small class="text-muted">

                            {{ __('purchases.create_description') }}

                        </small>

                    </div>



                    <a href="{{ route('purchases.index') }}" class="btn btn-outline-secondary">

                        <i class="bi bi-arrow-left"></i>

                        {{ __('purchases.back') }}

                    </a>


                </div>




                <form method="POST" action="{{ route('purchases.store') }}">

                    @csrf




                    {{-- بيانات الفاتورة --}}

                    <div class="card border-0 bg-light rounded-4 mb-4">

                        <div class="card-body">


                            <h5 class="mb-3">

                                <i class="bi bi-info-circle text-primary me-2"></i>

                                {{ __('purchases.invoice_information') }}

                            </h5>



                            <div class="row g-3">


                                <div class="col-md-6">

                                    <label class="form-label fw-semibold">

                                        {{ __('purchases.supplier') }}

                                    </label>



                                    <select id="supplier" name="supplier_id" class="form-select" required>


                                        <option value="">

                                            {{ __('purchases.choose_supplier') }}

                                        </option>



                                        @foreach($suppliers as $supplier)

                                            <option value="{{ $supplier->id }}">

                                                {{ $supplier->name }}

                                            </option>


                                        @endforeach


                                    </select>


                                </div>





                                <div class="col-md-6">


                                    <label class="form-label fw-semibold">

                                        {{ __('purchases.purchase_date') }}

                                    </label>



                                    <input type="date" name="purchase_date" value="{{ date('Y-m-d') }}" class="form-control"
                                        required>


                                </div>


                            </div>


                        </div>


                    </div>







                    {{-- الدفع --}}

                    <div class="card border-0 bg-light rounded-4 mb-4">


                        <div class="card-body">


                            <h5 class="mb-3">

                                <i class="bi bi-cash-coin text-success me-2"></i>

                                {{ __('purchases.payment_information') }}

                            </h5>



                            <div class="row g-3">


                                <div class="col-md-6">


                                    <label class="form-label fw-semibold">

                                        {{ __('purchases.paid_amount') }}

                                    </label>



                                    <input type="number" step="0.01" id="paid_amount" name="paid_amount" value="" dir="ltr"
                                        class="form-control">


                                </div>


                            </div>


                        </div>


                    </div>






                    {{-- الأصناف --}}

                    <div class="card border-0 shadow-sm rounded-4">


                        <div class="card-body">


                            <div class="d-flex justify-content-between align-items-center mb-3">


                                <h5 class="mb-0">

                                    <i class="bi bi-box-seam text-primary me-2"></i>

                                    {{ __('purchases.items') }}

                                </h5>




                                <button type="button" id="addProduct" class="btn btn-primary">


                                    <i class="bi bi-plus-lg"></i>

                                    {{ __('purchases.add_item') }}


                                </button>


                            </div>





                            <div class="table-responsive">


                                <table class="table table-bordered align-middle text-center">


                                    <thead class="table-light">


                                        <tr>


                                            <th>
                                                {{ __('purchases.product') }}
                                            </th>


                                            <th>
                                                {{ __('purchases.quantity') }}
                                            </th>


                                            <th>
                                                {{ __('purchases.purchase_price') }}
                                            </th>


                                            <th>
                                                {{ __('purchases.subtotal') }}
                                            </th>


                                            <th>
                                                {{ __('sales.actions') }}
                                            </th>


                                        </tr>


                                    </thead>



                                    <tbody id="productsContainer"></tbody>



                                </table>


                            </div>


                        </div>


                    </div>
                    {{-- الحساب --}}

                    <div class="card border-0 bg-light rounded-4 mt-4">

                        <div class="card-body">


                            <div class="row g-3">


                                <div class="col-md-4">

                                    <label class="form-label fw-bold">

                                        {{ __('purchases.total_amount') }}

                                    </label>


                                    <input type="text" id="total" value="" dir="ltr" class="form-control" readonly>

                                </div>




                                <div class="col-md-4">

                                    <label class="form-label fw-bold">

                                        {{ __('purchases.paid_amount') }}

                                    </label>


                                    <input type="text" id="paid_preview" value="" dir="ltr" class="form-control" readonly>

                                </div>




                                <div class="col-md-4">

                                    <label class="form-label fw-bold">

                                        {{ __('purchases.remaining_amount') }}

                                    </label>


                                    <input type="text" id="remaining" value="" dir="ltr" class="form-control" readonly>

                                </div>


                            </div>


                        </div>


                    </div>





                    <div class="text-end mt-4">


                        <button class="btn btn-success px-4">

                            <i class="bi bi-check-circle me-1"></i>

                            {{ __('purchases.save') }}

                        </button>



                        <a href="{{ route('purchases.index') }}" class="btn btn-outline-secondary px-4">

                            {{ __('purchases.cancel') }}

                        </a>


                    </div>



                </form>


            </div>

        </div>

    </div>



    <script>

        let products = [];
        let row = 0;


        function formatNumber(value) {

            value = Number(value) || 0;

            return value.toLocaleString('en-US', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 2
            });

        }



        document.addEventListener('DOMContentLoaded', function () {



            const supplier = document.getElementById('supplier');
            const productsContainer = document.getElementById('productsContainer');
            const addProductBtn = document.getElementById('addProduct');



            supplier.addEventListener('change', function () {


                let supplierId = this.value;


                products = [];

                productsContainer.innerHTML = '';



                if (!supplierId) {

                    return;

                }




                fetch("{{ url('/purchases/supplier') }}/" + supplierId + "/products")

                    .then(res => res.json())

                    .then(data => {


                        products = data;


                        addProduct();


                    })

                    .catch(error => console.log(error));



            });







            addProductBtn.addEventListener('click', function () {

                addProduct();

            });







        });







        function productOptions() {


            let html = `
                        <option value="">
                            {{ __('purchases.choose_product') }}
                        </option>
                    `;



            products.forEach(product => {


                html += `

                        <option value="${product.id}">
                            ${product.name}
                        </option>

                        `;


            });



            return html;

        }







        function addProduct() {



            let html = `

                <tr>


                <td>

                <select name="items[${row}][product_id]"
                class="form-select"
                required>

                ${productOptions()}

                </select>


                </td>



                <td>

                <input type="number"
                name="items[${row}][quantity]"
                class="form-control quantity"
                min="1"
                value="1"
                required>

                </td>



                <td>

                <input type="number"
                step="0.01"
                name="items[${row}][price]"
                class="form-control price"
                required>

                </td>



                <td>

                <input type="text"
                class="form-control subtotal"
                value="0"
                readonly>

                </td>



                <td>

                <button type="button"
                class="btn btn-danger remove">

                <i class="bi bi-trash"></i>

                </button>

                </td>


                </tr>

                `;



            document
                .getElementById('productsContainer')
                .insertAdjacentHTML('beforeend', html);



            row++;

            calculate();


        }







        document.addEventListener('input', function (e) {


            if (
                e.target.classList.contains('quantity') ||
                e.target.classList.contains('price') ||
                e.target.id === 'paid_amount'
            ) {

                calculate();

            }


        });









        function calculate() {


            let total = 0;



            document.querySelectorAll('#productsContainer tr')
                .forEach(tr => {


                    let q = Number(
                        tr.querySelector('.quantity').value
                    ) || 0;


                    let p = Number(
                        tr.querySelector('.price').value
                    ) || 0;



                    let subtotal = q * p;



                    tr.querySelector('.subtotal').value =
                        formatNumber(subtotal);



                    total += subtotal;



                });




            let paid =
                Number(
                    document.getElementById('paid_amount').value
                ) || 0;



            let remaining = total - paid;



            document.getElementById('total').value =
                formatNumber(total);



            document.getElementById('paid_preview').value =
                formatNumber(paid);



            document.getElementById('remaining').value =
                remaining > 0
                    ?
                    formatNumber(remaining)
                    :
                    '0';



        }









        document.addEventListener('click', function (e) {


            if (e.target.closest('.remove')) {


                e.target.closest('tr').remove();


                calculate();


            }


        });


    </script>


@endsection