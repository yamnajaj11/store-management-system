@extends('layouts.app')

@section('title', __('prices.title'))

@section('content')

    <div class="container-fluid">

        <div class="bg-white p-4 shadow-sm rounded-3">


            <div class="d-flex justify-content-between align-items-center mb-4">


                <h4 class="mb-0">

                    <i class="bi bi-tags text-primary me-2"></i>

                    {{ __('prices.title') }}

                </h4>



                <div class="d-flex gap-2">


                    <form method="GET" class="d-flex">

                        <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                            placeholder="{{ __('prices.search') }}">


                        <button class="btn btn-primary ms-2">

                            <i class="bi bi-search"></i>

                        </button>


                    </form>




                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#bulkPriceModal">


                        <i class="bi bi-tags"></i>

                        {{ __('prices.bulk_price') }}


                    </button>


                </div>


            </div>





            @if(session('success'))

                <div class="alert alert-success">

                    {{ session('success') }}

                </div>

            @endif





            <div class="table-responsive">


                <table class="table table-hover table-bordered text-center align-middle">


                    <thead class="table-light">


                        <tr>


                            <th>
                                {{ __('products.number') }}
                            </th>


                            <th>
                                {{ __('prices.product') }}
                            </th>


                            <th>
                                {{ __('prices.stock') }}
                            </th>


                            <th>
                                {{ __('prices.last_purchase') }}
                            </th>


                            <th>
                                {{ __('prices.average_cost') }}
                            </th>


                            <th>
                                {{ __('prices.selling_price') }}
                            </th>


                            <th>
                                {{ __('prices.profit') }}
                            </th>


                            <th>
                                {{ __('prices.profit_percentage') }}
                            </th>


                            <th>
                                {{ __('prices.actions') }}
                            </th>


                        </tr>


                    </thead>




                    <tbody>


                        @forelse($products as $product)


                            <tr>


                                <td>

                                    {{ $product->product_number }}

                                </td>



                                <td>

                                    <strong>

                                        {{ $product->name }}

                                    </strong>

                                </td>



                                <td>

                                    @if($product->stock > 0)

                                        <span class="badge bg-success">

                                            {{ $product->stock }}

                                        </span>

                                    @else

                                        <span class="badge bg-danger">

                                            0

                                        </span>

                                    @endif

                                </td>




                                <td>

                                    {{ rtrim(rtrim(number_format($product->last_purchase_price, 2), '0'), '.') }}

                                </td>




                                <td>

                                    {{ rtrim(rtrim(number_format($product->average_cost, 2), '0'), '.') }}

                                </td>




                                <td>

                                    {{ rtrim(rtrim(number_format($product->selling_price, 2), '0'), '.') }}

                                </td>




                                <td>


                                    @if($product->profit > 0)

                                        <span class="badge bg-success">

                                            {{ rtrim(rtrim(number_format($product->profit, 2), '0'), '.') }}

                                        </span>


                                    @elseif($product->profit < 0)

                                        <span class="badge bg-danger">

                                            {{ rtrim(rtrim(number_format($product->profit, 2), '0'), '.') }}

                                        </span>


                                    @else

                                        <span class="badge bg-secondary">

                                            0

                                        </span>

                                    @endif


                                </td>




                                <td>


                                    @if($product->profit_percentage > 0)

                                        <span class="badge bg-info">

                                            {{ rtrim(rtrim(number_format($product->profit_percentage, 1), '0'), '.') }} %

                                        </span>


                                    @else

                                        <span class="badge bg-secondary">

                                            0 %

                                        </span>


                                    @endif


                                </td>




                                <td>


                                    <button class="btn btn-warning btn-sm editPrice" data-id="{{ $product->id }}"
                                        data-name="{{ $product->name }}" data-purchase="{{ $product->purchase_price }}"
                                        data-selling="{{ $product->selling_price }}">


                                        <i class="bi bi-pencil-square"></i>


                                    </button>


                                </td>


                            </tr>



                        @empty


                            <tr>

                                <td colspan="9">

                                    {{ __('prices.no_products') }}

                                </td>

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





    {{-- تعديل سعر منتج --}}


    <div class="modal fade" id="priceModal">


        <div class="modal-dialog">


            <div class="modal-content">


                <form id="priceForm" method="POST">


                    @csrf

                    @method('PUT')



                    <div class="modal-header">


                        <h5 class="modal-title">

                            {{ __('prices.edit_price') }}

                        </h5>


                        <button type="button" class="btn-close" data-bs-dismiss="modal">

                        </button>


                    </div>




                    <div class="modal-body">



                        <div class="mb-3">


                            <label class="form-label">

                                {{ __('prices.product') }}

                            </label>


                            <input id="product_name" class="form-control" readonly>


                        </div>




                        <div class="mb-3">


                            <label class="form-label">

                                {{ __('prices.purchase_price') }}

                            </label>


                            <input type="number" step="0.01" name="purchase_price" id="purchase_price" class="form-control"
                                required>


                        </div>




                        <div class="mb-3">


                            <label class="form-label">

                                {{ __('prices.selling_price') }}

                            </label>


                            <input type="number" step="0.01" name="selling_price" id="selling_price" class="form-control"
                                required>


                        </div>


                    </div>





                    <div class="modal-footer">


                        <button class="btn btn-success">

                            <i class="bi bi-check-circle"></i>

                            {{ __('prices.save') }}

                        </button>



                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                            {{ __('prices.cancel') }}

                        </button>


                    </div>


                </form>


            </div>


        </div>


    </div>





    {{-- التسعير الجماعي --}}


    <div class="modal fade" id="bulkPriceModal">


        <div class="modal-dialog modal-xl">


            <div class="modal-content">


                <form method="POST" action="{{ route('prices.bulkUpdate') }}">


                    @csrf



                    <div class="modal-header">


                        <h5 class="modal-title">

                            {{ __('prices.bulk_price') }}

                        </h5>


                        <button type="button" class="btn-close" data-bs-dismiss="modal">

                        </button>


                    </div>




                    <div class="modal-body">


                        <div class="table-responsive">


                            <table class="table table-bordered text-center">


                                <thead class="table-light">


                                    <tr>


                                        <th>

                                            {{ __('products.number') }}

                                        </th>


                                        <th>

                                            {{ __('prices.product') }}

                                        </th>


                                        <th>

                                            {{ __('prices.purchase_price') }}

                                        </th>


                                        <th>

                                            {{ __('prices.selling_price') }}

                                        </th>


                                    </tr>


                                </thead>



                                <tbody>


                                    @foreach($allProducts as $product)


                                        <tr>


                                            <td>

                                                {{ $product->product_number }}

                                            </td>



                                            <td>

                                                {{ $product->name }}

                                            </td>



                                            <td>

                                                {{ $product->purchase_price }}

                                            </td>



                                            <td>


                                                <input type="number" step="0.01" dir="ltr" lang="en" class="form-control"
                                                    name="prices[{{ $product->id }}]"
                                                    value="{{ $product->selling_price > 0 ? $product->selling_price : '' }}">
                                            </td>



                                        </tr>


                                    @endforeach


                                </tbody>


                            </table>


                        </div>


                    </div>





                    <div class="modal-footer">


                        <button class="btn btn-success">

                            <i class="bi bi-check-circle"></i>

                            {{ __('prices.save') }}

                        </button>


                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                            {{ __('prices.cancel') }}

                        </button>


                    </div>



                </form>


            </div>


        </div>


    </div>






    <script>
        document.querySelectorAll('.editPrice')
            .forEach(function (btn) {


                btn.addEventListener('click', function () {


                    document.getElementById('product_name').value =
                        this.dataset.name;


                    document.getElementById('purchase_price').value =
                        this.dataset.purchase;


                    document.getElementById('selling_price').value =
                        this.dataset.selling;



                    document.getElementById('priceForm').action =
                        '/prices/' + this.dataset.id;



                    new bootstrap.Modal(
                        document.getElementById('priceModal')
                    ).show();



                });


            });
    </script>



@endsection