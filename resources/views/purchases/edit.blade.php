@extends('layouts.app')

@section('title', __('purchases.edit_purchase'))

@section('content')

    <div class="container-fluid">

        <div class="bg-white p-4 shadow-sm rounded-3">


            <div class="d-flex justify-content-between align-items-center mb-4">


                <h4 class="mb-0">

                    <i class="bi bi-pencil-square text-warning me-2"></i>

                    {{ __('purchases.edit_purchase') }}

                </h4>



                <a href="{{ route('purchases.index') }}" class="btn btn-secondary btn-sm">

                    <i class="bi bi-arrow-left"></i>

                    {{ __('purchases.back') }}

                </a>


            </div>





            @if($purchase->paid_amount >= $purchase->total_amount)

                <div class="alert alert-danger">

                    <i class="bi bi-lock-fill"></i>

                    {{ __('purchases.fully_paid_invoice') }}

                    <br>

                    {{ __('purchases.cannot_edit_paid_invoice') }}

                    <br>

                    {{ __('purchases.use_return_system') }}

                </div>

            @endif





            <form action="{{ route('purchases.update', $purchase->id) }}" method="POST">

                @csrf
                @method('PUT')





                <div class="card shadow-sm mb-4">

                    <div class="card-body">


                        <div class="row g-3">



                            <div class="col-md-6">


                                <label class="form-label">

                                    {{ __('purchases.supplier') }}

                                </label>



                                <select id="supplier" name="supplier_id" class="form-select" required>


                                    @foreach($suppliers as $supplier)

                                        <option value="{{ $supplier->id }}" @selected($supplier->id == $purchase->supplier_id)>

                                            {{ $supplier->name }}

                                        </option>

                                    @endforeach


                                </select>


                            </div>





                            <div class="col-md-6">


                                <label class="form-label">

                                    {{ __('purchases.purchase_date') }}

                                </label>



                                <input type="date" name="purchase_date" class="form-control"
                                    value="{{ $purchase->purchase_date->format('Y-m-d') }}" required>


                            </div>



                        </div>


                    </div>

                </div>







                <div class="card shadow-sm">


                    <div class="card-body">



                        <div class="d-flex justify-content-between align-items-center mb-3">


                            <h5 class="mb-0">

                                <i class="bi bi-box-seam"></i>

                                {{ __('purchases.purchase_items') }}

                            </h5>




                            @if($purchase->paid_amount < $purchase->total_amount)

                                <button type="button" id="addRow" class="btn btn-primary btn-sm">

                                    <i class="bi bi-plus-lg"></i>

                                    {{ __('purchases.add_item') }}

                                </button>

                            @endif


                        </div>





                        <div class="table-responsive">


                            <table class="table table-bordered text-center align-middle">


                                <thead class="table-light">

                                    <tr>


                                        <th>{{ __('purchases.product') }}</th>

                                        <th>{{ __('purchases.quantity') }}</th>

                                        <th>{{ __('purchases.price') }}</th>


                                        <th>{{ __('purchases.subtotal') }}</th>

                                        <th>{{ __('purchases.actions') }}</th>


                                    </tr>

                                </thead>





                                <tbody id="items">


                                    @foreach($purchase->items as $index => $item)


                                        <tr>


                                            <td>


                                                <select name="items[{{ $index }}][product_id]"
                                                    class="form-select product-select" required>


                                                    @foreach($products as $product)

                                                        <option value="{{ $product->id }}"
                                                            @selected($product->id == $item->product_id)>

                                                            {{ $product->name }}

                                                        </option>

                                                    @endforeach


                                                </select>


                                            </td>

                                            <td>

                                                <input type="number" name="items[{{ $index }}][quantity]"
                                                    class="form-control quantity" min="1" value="{{ $item->quantity }}"
                                                    dir="ltr" required>

                                            </td>




                                            <td>

                                                <input type="number" step="0.01" name="items[{{ $index }}][price]"
                                                    class="form-control price" value="{{ formatAmount($item->price) }}"
                                                    dir="ltr" lang="en" required>

                                            </td>








                                            <td>

                                                <input type="text" class="form-control subtotal"
                                                    value="{{ formatAmount($item->subtotal) }}" dir="ltr" readonly>

                                            </td>




                                            <td>


                                                @if($purchase->paid_amount >= $purchase->total_amount)


                                                    <a href="{{ route('purchase_returns.create', $purchase->id) }}"
                                                        class="btn btn-warning">

                                                        <i class="bi bi-arrow-counterclockwise"></i>

                                                    </a>


                                                @else


                                                    <button type="button" class="btn btn-danger removeRow">

                                                        <i class="bi bi-trash"></i>

                                                    </button>


                                                @endif


                                            </td>



                                        </tr>


                                    @endforeach


                                </tbody>





                                <tfoot>

                                    <tr>

                                        <th colspan="3">

                                            {{ __('purchases.items_total') }}

                                        </th>


                                        <th>

                                            <input id="total" class="form-control" dir="ltr" readonly>

                                        </th>


                                        <th></th>


                                    </tr>


                                </tfoot>



                            </table>


                        </div>


                    </div>

                </div>





                <div class="text-end mt-4">


                    <button class="btn btn-success">


                        <i class="bi bi-check-circle"></i>

                        {{ __('purchases.update') }}


                    </button>




                    <a href="{{ route('purchases.index') }}" class="btn btn-secondary">

                        {{ __('purchases.cancel') }}

                    </a>


                </div>



            </form>



        </div>

    </div>





    <script>


        let row = {{ $purchase->items->count() }};


        let products = @json($products);



        const lockedPurchase = {{ $purchase->paid_amount >= $purchase->total_amount ? 'true' : 'false' }};






        function formatNumber(value) {

            value = Number(value) || 0;

            return String(
                Number(value).toFixed(2)
            )
                .replace(/\.00$/, '');

        }






        function calculate() {

            let total = 0;



            $('.quantity').each(function () {



                let tr = $(this).closest('tr');



                let quantity =
                    Number(tr.find('.quantity').val()) || 0;



                let price =
                    Number(tr.find('.price').val()) || 0;




                let subtotal = quantity * price;



                tr.find('.subtotal')
                    .val(formatNumber(subtotal));



                total += subtotal;



            });




            $('#total')
                .val(formatNumber(total));


        }







        $(document).on(
            'input',
            '.quantity,.price',
            function () {


                if (!lockedPurchase) {

                    calculate();

                }


            });







        $(document).on(
            'click',
            '.removeRow',
            function () {



                if (lockedPurchase) {


                    alert('{{ __("purchases.use_return_instead") }}');


                    return;


                }




                $(this)
                    .closest('tr')
                    .remove();



                calculate();


            });








        $(document).ready(function () {


            calculate();


        });



    </script>



@endsection