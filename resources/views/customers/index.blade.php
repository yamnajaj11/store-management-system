@extends('layouts.app')

@section('title', __('customers.customers'))

@section('content')

    <div class="container-fluid">

        <div class="bg-white p-4 shadow-sm rounded-3">


            <div class="d-flex justify-content-between align-items-center mb-4">

                <h4 class="mb-0">
                    <i class="bi bi-people text-primary me-2"></i>
                    {{ __('customers.customers') }}
                </h4>


                <a href="{{ route('customers.create') }}" class="btn btn-primary">

                    <i class="bi bi-plus-lg"></i>

                    {{ __('customers.add_customer') }}

                </a>

            </div>




            <form method="GET" action="{{ route('customers.index') }}" class="row g-2 mb-4">


                <div class="col-md-4">

                    <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                        placeholder="{{ __('customers.search_by_name_or_phone') }}">

                </div>



                <div class="col-md-3">

                    <select name="has_sales" class="form-select">

                        <option value="">
                            {{ __('customers.all_customers') }}
                        </option>


                        <option value="1" {{ request('has_sales') == '1' ? 'selected' : '' }}>

                            {{ __('customers.has_sales_only') }}

                        </option>


                    </select>

                </div>



                <div class="col-md-2">

                    <button class="btn btn-dark w-100">

                        <i class="bi bi-search"></i>

                        {{ __('customers.search') }}

                    </button>

                </div>


            </form>





            <div class="table-responsive">


                <table class="table table-hover table-bordered text-center align-middle">


                    <thead class="table-light">


                        <tr>


                            <th>{{ __('customers.number') }}</th>

                            <th>{{ __('customers.name') }}</th>

                            <th>{{ __('customers.phone') }}</th>

                            <th>{{ __('customers.sales_count') }}</th>

                            <th>{{ __('customers.total_sales') }}</th>

                            <th>{{ __('customers.balance') }}</th>

                            <th>{{ __('customers.status') }}</th>

                            <th>{{ __('customers.actions') }}</th>


                        </tr>


                    </thead>



                    <tbody>


                        @forelse($customers as $customer)


                            <tr>




                                <td>
                                    {{ $customer->customer_number }}
                                </td>



                                <td>

                                    <strong>
                                        {{ $customer->name }}
                                    </strong>

                                </td>



                                <td>

                                    {{ $customer->phone ?? '-' }}

                                </td>



                                <td>

                                    {{ $customer->sales_count }}

                                </td>



                                <td>

                                    {{ number_format($customer->sales_sum_total_amount ?? 0, 2) }}

                                </td>



                                <td>

                                    {{ number_format($customer->balance, 2) }}

                                </td>



                                <td>


                                    @if($customer->is_active)

                                        <span class="badge bg-success">

                                            {{ __('customers.active') }}

                                        </span>

                                    @else

                                        <span class="badge bg-danger">

                                            {{ __('customers.inactive') }}

                                        </span>

                                    @endif


                                </td>



                                <td>


                                    <a href="{{ route('customers.show', $customer->id) }}"
                                        class="btn btn-sm btn-outline-primary">

                                        <i class="bi bi-eye"></i>

                                    </a>



                                    <a href="{{ route('customers.edit', $customer->id) }}"
                                        class="btn btn-sm btn-outline-warning">

                                        <i class="bi bi-pencil"></i>

                                    </a>



                                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST"
                                        class="d-inline">


                                        @csrf
                                        @method('DELETE')


                                        <button type="submit" onclick="return confirm('{{ __('customers.confirm_delete') }}')"
                                            class="btn btn-sm btn-outline-danger">


                                            <i class="bi bi-trash"></i>


                                        </button>


                                    </form>


                                </td>


                            </tr>


                        @empty


                            <tr>

                                <td colspan="9" class="text-muted">

                                    {{ __('customers.no_customers_found') }}

                                </td>

                            </tr>


                        @endforelse


                    </tbody>


                </table>


            </div>




            <div class="mt-3">

                {{ $customers->links() }}

            </div>


        </div>

    </div>


@endsection