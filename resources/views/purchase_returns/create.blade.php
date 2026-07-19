@extends('layouts.app')

@section('title', __('purchase_returns.create_title'))

@section('content')

    <div class="container-fluid">

        <div class="card shadow-sm rounded-4">

            <div class="card-body p-4">


                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>

                        <h4 class="fw-bold mb-1">

                            <i class="bi bi-arrow-counterclockwise text-danger"></i>

                            {{ __('purchase_returns.create_title') }}

                        </h4>


                        <small class="text-muted">

                            {{ __('purchase_returns.create_description') }}

                        </small>


                    </div>



                    <a href="{{ route('purchases.index') }}" class="btn btn-secondary">

                        <i class="bi bi-arrow-left"></i>

                        {{ __('purchase_returns.back') }}

                    </a>


                </div>




                <div class="alert alert-warning">

                    <i class="bi bi-exclamation-triangle"></i>

                    {{ __('purchase_returns.warning') }}

                </div>





                <form method="POST" action="{{ route('purchase_returns.store') }}">

                    @csrf


                    <input type="hidden" name="purchase_id" value="{{ $purchase->id }}">





                    <div class="card bg-light border-0 rounded-4 mb-4">


                        <div class="card-body">


                            <div class="row g-3">



                                <div class="col-md-4">

                                    <label class="form-label fw-bold">

                                        {{ __('purchase_returns.supplier') }}

                                    </label>


                                    <input type="text" class="form-control" value="{{ $purchase->supplier->name }}"
                                        readonly>

                                </div>




                                <div class="col-md-4">


                                    <label class="form-label fw-bold">

                                        {{ __('purchase_returns.purchase_date') }}

                                    </label>


                                    <input type="text" class="form-control"
                                        value="{{ $purchase->purchase_date->format('Y-m-d') }}" readonly>


                                </div>




                                <div class="col-md-4">


                                    <label class="form-label fw-bold">

                                        {{ __('purchase_returns.return_date') }}

                                    </label>


                                    <input type="date" name="return_date" class="form-control" value="{{ date('Y-m-d') }}"
                                        required>


                                </div>



                            </div>


                        </div>


                    </div>







                    <div class="card shadow-sm rounded-4">


                        <div class="card-body">



                            <h5 class="fw-bold mb-3">


                                <i class="bi bi-box-seam"></i>


                                {{ __('purchase_returns.items') }}


                            </h5>






                            <div class="table-responsive">


                                <table class="table table-bordered text-center align-middle">


                                    <thead class="table-light">


                                        <tr>


                                            <th>
                                                {{ __('purchase_returns.product') }}
                                            </th>


                                            <th>
                                                {{ __('purchase_returns.original_quantity') }}
                                            </th>


                                            <th>
                                                {{ __('purchase_returns.returned_before') }}
                                            </th>


                                            <th>
                                                {{ __('purchase_returns.available') }}
                                            </th>


                                            <th>
                                                {{ __('purchase_returns.return_quantity') }}
                                            </th>


                                            <th>
                                                {{ __('purchase_returns.amount') }}
                                            </th>


                                        </tr>


                                    </thead>





                                    <tbody>



                                        @forelse($purchase->items as $index => $item)


                                            @if($item->available_quantity > 0)


                                                <tr>


                                                    <td>


                                                        {{ $item->product->name }}


                                                        <input type="hidden" name="items[{{ $index }}][purchase_item_id]"
                                                            value="{{ $item->id }}">


                                                    </td>





                                                    <td>

                                                        {{ $item->quantity }}

                                                    </td>





                                                    <td>

                                                        {{ $item->returned_quantity }}

                                                    </td>





                                                    <td>


                                                        <span class="badge bg-success">

                                                            {{ $item->available_quantity }}

                                                        </span>


                                                    </td>





                                                    <td>


                                                        <input type="number" name="items[{{ $index }}][quantity]"
                                                            class="form-control return-qty" min="0"
                                                            max="{{ $item->available_quantity }}" data-price="{{ $item->price }}"
                                                            value="0">


                                                    </td>





                                                    <td>


                                                        <input type="text" class="form-control line-total" readonly value="0">


                                                    </td>


                                                </tr>


                                            @endif



                                        @empty


                                            <tr>

                                                <td colspan="6">

                                                    {{ __('purchase_returns.no_items') }}

                                                </td>

                                            </tr>


                                        @endforelse



                                    </tbody>





                                    <tfoot>


                                        <tr>


                                            <th colspan="5">

                                                {{ __('purchase_returns.total') }}

                                            </th>


                                            <th>


                                                <input id="total" class="form-control fw-bold" readonly value="0">


                                            </th>


                                        </tr>


                                    </tfoot>



                                </table>


                            </div>



                        </div>


                    </div>







                    <div class="card bg-light border-0 rounded-4 mt-4">


                        <div class="card-body">


                            <label class="form-label fw-bold">

                                {{ __('purchase_returns.notes') }}

                            </label>


                            <textarea name="note" class="form-control" rows="3"></textarea>


                        </div>


                    </div>






                    <div class="text-end mt-4">


                        <button class="btn btn-danger px-4">


                            <i class="bi bi-check-circle"></i>


                            {{ __('purchase_returns.save') }}


                        </button>


                    </div>




                </form>


            </div>


        </div>


    </div>






    <script>


        function format(number) {

            number = Number(number);


            if (number === 0) {
                return '0';
            }


            return number
                .toFixed(2)
                .replace('.00', '');

        }





        function calculateReturn() {

            let total = 0;



            $('.return-qty').each(function () {


                let qty = parseFloat($(this).val()) || 0;


                let price = parseFloat($(this).data('price')) || 0;


                let value = qty * price;



                $(this)
                    .closest('tr')
                    .find('.line-total')
                    .val(format(value));



                total += value;



            });



            $('#total').val(format(total));


        }






        $(document).on(
            'input',
            '.return-qty',
            function () {

                calculateReturn();

            }
        );




        $(document).ready(function () {

            calculateReturn();

        });


    </script>



@endsection