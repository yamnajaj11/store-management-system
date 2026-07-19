@extends('layouts.app')

@section('title', __('inventory.inventory'))

@section('content')

    <div class="container-fluid">

        <div class="bg-white p-4 shadow-sm rounded-3">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <h4 class="mb-0">
                    <i class="bi bi-box-seam text-primary me-2"></i>
                    {{ __('inventory.inventory') }}
                </h4>


                <form method="GET" action="{{ route('inventory.index') }}" class="d-flex">

                    <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                        placeholder="{{ __('inventory.search') }}">

                    <button class="btn btn-primary ms-2">
                        <i class="bi bi-search"></i>
                        {{ __('inventory.search') }}
                    </button>

                </form>

            </div>



            <div class="table-responsive">

                <table class="table table-hover text-center align-middle">

                    <thead class="table-light">

                        <tr>
                            <th>
                                {{ __('products.number') }}
                            </th>
                            <th>{{ __('inventory.product') }}</th>
                            <th>{{ __('inventory.unit') }}</th>
                            <th>{{ __('inventory.quantity') }}</th>
                            <th>{{ __('inventory.purchase_price') }}</th>
                            <th>{{ __('inventory.selling_price') }}</th>
                            <th>{{ __('inventory.status') }}</th>
                        </tr>

                    </thead>


                    <tbody>

                        @forelse($products as $product)

                            <tr>

                                <td>
                                    {{ $product->product_number }}
                                </td>
                                <td>
                                    {{ $product->name }}
                                </td>

                                <td>
                                    {{ $product->unit }}
                                </td>


                                <td>
                                    {{ $product->stock }}
                                </td>


                                <td>
                                    {{ number_format($product->purchase_price, 2) }}
                                </td>


                                <td>
                                    {{ number_format($product->selling_price, 2) }}
                                </td>


                                <td>

                                    @if($product->stock <= 0)

                                        <span class="badge bg-danger">
                                            {{ __('inventory.out_of_stock') }}
                                        </span>

                                    @elseif($product->stock <= 5)

                                        <span class="badge bg-warning text-dark">
                                            {{ __('inventory.low_stock') }}
                                        </span>

                                    @else

                                        <span class="badge bg-success">
                                            {{ __('inventory.available') }}
                                        </span>

                                    @endif


                                </td>


                            </tr>


                        @empty

                            <tr>
                                <td colspan="7" class="text-muted">
                                    {{ __('inventory.no_products') }}
                                </td>
                            </tr>


                        @endforelse


                    </tbody>


                </table>


            </div>


        </div>

    </div>

@endsection