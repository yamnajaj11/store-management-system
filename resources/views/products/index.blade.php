@extends('layouts.app')

@section('title', __('products.products'))

@section('content')

    <div class="container-fluid">

        <div class="bg-white p-4 shadow-sm rounded-4 border">


            <div class="d-flex justify-content-between align-items-center mb-4">


                <h4 class="mb-0 text-primary fw-bold">

                    <i class="bi bi-box-seam me-2"></i>

                    {{ __('products.products') }}

                </h4>



                <div class="d-flex gap-2">


                    <a href="{{ route('products.bulkCreate') }}" class="btn btn-success">

                        <i class="bi bi-boxes me-1"></i>

                        {{ __('products.bulk_add_product') }}

                    </a>



                    <a href="{{ route('products.create') }}" class="btn btn-primary">

                        <i class="bi bi-plus-lg me-1"></i>

                        {{ __('products.add_product') }}

                    </a>


                </div>


            </div>





            <form method="GET" action="{{ route('products.index') }}" class="row g-2 mb-4">


                <div class="col-md-4">


                    <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                        placeholder="{{ __('products.search_by_name') }}">


                </div>



                <div class="col-md-2">


                    <button class="btn btn-dark w-100">


                        <i class="bi bi-search me-1"></i>

                        {{ __('products.search') }}


                    </button>


                </div>


            </form>







            <div class="table-responsive">


                <table class="table table-hover align-middle text-center">


                    <thead class="table-light">


                        <tr>


                            <th>
                                {{ __('products.number') }}
                            </th>

                            <th>{{ __('products.name') }}</th>


                            <th>{{ __('products.suppliers') }}</th>


                            <th>{{ __('products.unit') }}</th>


                            <th>{{ __('products.stock') }}</th>


                            <th>{{ __('products.actions') }}</th>


                        </tr>


                    </thead>





                    <tbody>


                        @forelse($products as $product)


                            <tr>


                                <td>
                                    {{ $product->product_number }}
                                </td>



                                <td class="fw-semibold">

                                    {{ $product->name }}

                                </td>





                                <td>


                                    @forelse($product->suppliers as $supplier)


                                        <span class="badge bg-info text-dark me-1">

                                            {{ $supplier->name }}

                                        </span>


                                    @empty

                                        -

                                    @endforelse


                                </td>






                                <td>

                                    {{ $product->unit ?? '-' }}

                                </td>





                                <td>


                                    @if($product->stock <= 0)


                                        <span class="badge bg-danger">

                                            {{ __('products.out_of_stock') }}

                                        </span>


                                    @elseif($product->stock <= 5)


                                        <span class="badge bg-warning text-dark">

                                            {{ $product->stock }}

                                        </span>


                                    @else


                                        <span class="badge bg-success">

                                            {{ $product->stock }}

                                        </span>


                                    @endif


                                </td>







                                <td>


                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-outline-primary">


                                        <i class="bi bi-eye"></i>


                                    </a>




                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-warning">


                                        <i class="bi bi-pencil"></i>


                                    </a>






                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">


                                        @csrf

                                        @method('DELETE')



                                        <button class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('{{ __('products.confirm_delete') }}')">


                                            <i class="bi bi-trash"></i>


                                        </button>



                                    </form>



                                </td>



                            </tr>



                        @empty



                            <tr>


                                <td colspan="6" class="text-muted">


                                    {{ __('products.no_products_found') }}


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


@endsection