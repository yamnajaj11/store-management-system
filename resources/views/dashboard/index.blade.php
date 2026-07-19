@extends('layouts.app')

@section('title', __('dashboard.title'))

@section('content')

    <div class="container-fluid">


        {{-- العنوان --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-body p-4">

                <h3 class="fw-bold mb-2">
                    <i class="bi bi-speedometer2 text-primary me-2"></i>

                    {{ __('dashboard.title') }}
                </h3>


                <p class="text-muted mb-0">
                    {{ __('dashboard.welcome') }}
                </p>

            </div>

        </div>





        {{-- الإحصائيات --}}

        <div class="row g-3 mb-4">



            <div class="col-md-3">

                <div class="card border-0 shadow-sm rounded-4 text-center">

                    <div class="card-body">

                        <i class="bi bi-receipt fs-1 text-success"></i>

                        <h6 class="mt-2">
                            المبيعات
                        </h6>

                        <h4 class="fw-bold">

                            {{ number_format($stats['sales'], 2) }}

                        </h4>

                    </div>

                </div>

            </div>






            <div class="col-md-3">

                <div class="card border-0 shadow-sm rounded-4 text-center">

                    <div class="card-body">

                        <i class="bi bi-cart fs-1 text-warning"></i>

                        <h6 class="mt-2">
                            المشتريات
                        </h6>

                        <h4 class="fw-bold">

                            {{ number_format($stats['purchases'], 2) }}

                        </h4>

                    </div>

                </div>

            </div>






            <div class="col-md-3">

                <div class="card border-0 shadow-sm rounded-4 text-center">

                    <div class="card-body">

                        <i class="bi bi-cash-coin fs-1 text-primary"></i>

                        <h6 class="mt-2">
                            المقبوض من العملاء
                        </h6>

                        <h4 class="fw-bold">

                            {{ number_format($stats['payments'], 2) }}

                        </h4>

                    </div>

                </div>

            </div>






            <div class="col-md-3">

                <div class="card border-0 shadow-sm rounded-4 text-center">

                    <div class="card-body">

                        <i class="bi bi-exclamation-triangle fs-1 text-danger"></i>

                        <h6 class="mt-2">
                            مخزون منخفض
                        </h6>

                        <h4 class="fw-bold">

                            {{ $stats['low_stock'] }}

                        </h4>

                    </div>

                </div>

            </div>


        </div>







        <div class="row g-3 mb-4">


            <div class="col-md-6">


                <div class="card border-0 shadow-sm rounded-4">


                    <div class="card-body">


                        <h5 class="fw-bold">

                            <i class="bi bi-person-lines-fill text-danger me-2"></i>

                            ديون العملاء

                        </h5>


                        <h3 class="text-danger fw-bold">

                            {{ number_format($stats['customer_debt'], 2) }}

                        </h3>


                    </div>


                </div>


            </div>





            <div class="col-md-6">


                <div class="card border-0 shadow-sm rounded-4">


                    <div class="card-body">


                        <h5 class="fw-bold">

                            <i class="bi bi-building text-warning me-2"></i>

                            ديون الموردين

                        </h5>


                        <h3 class="text-warning fw-bold">

                            {{ number_format($stats['supplier_debt'], 2) }}

                        </h3>


                    </div>


                </div>


            </div>



        </div>








        {{-- آخر المبيعات --}}


        <div class="card border-0 shadow-sm rounded-4 mb-4">


            <div class="card-header bg-white border-0 p-4">

                <h5 class="fw-bold mb-0">

                    <i class="bi bi-receipt-cutoff text-success me-2"></i>

                    آخر المبيعات

                </h5>

            </div>



            <div class="card-body">


                <div class="table-responsive">


                    <table class="table table-bordered text-center align-middle">


                        <thead class="table-light">

                            <tr>

                                <th>الفاتورة</th>

                                <th>العميل</th>

                                <th>المبلغ</th>

                                <th>الحالة</th>

                            </tr>


                        </thead>



                        <tbody>


                            @forelse($latestSales as $sale)


                                <tr>


                                    <td>

                                        {{ $sale->invoice_number }}

                                    </td>



                                    <td>

                                        {{ $sale->customer->name ?? 'عميل عام' }}

                                    </td>



                                    <td>

                                        {{ number_format($sale->final_amount, 2) }}

                                    </td>



                                    <td>

                                        {{ $sale->status }}

                                    </td>


                                </tr>


                            @empty


                                <tr>

                                    <td colspan="4">

                                        لا يوجد بيانات

                                    </td>

                                </tr>


                            @endforelse


                        </tbody>


                    </table>


                </div>


            </div>


        </div>









        {{-- آخر الحركات --}}


        <div class="card border-0 shadow-sm rounded-4">


            <div class="card-header bg-white border-0 p-4">


                <h5 class="fw-bold mb-0">

                    <i class="bi bi-arrow-left-right text-primary me-2"></i>

                    آخر حركات المخزون

                </h5>


            </div>



            <div class="card-body">


                <div class="table-responsive">


                    <table class="table table-bordered text-center">


                        <thead class="table-light">


                            <tr>

                                <th>المنتج</th>

                                <th>الحركة</th>

                                <th>الكمية</th>

                                <th>التاريخ</th>

                            </tr>


                        </thead>



                        <tbody>


                            @foreach($latestMovements as $movement)


                                <tr>


                                    <td>

                                        {{ $movement->product->name ?? '-' }}

                                    </td>



                                    <td>

                                        @if($movement->quantity > 0)

                                            <span class="badge bg-success">

                                                دخول

                                            </span>

                                        @else

                                            <span class="badge bg-danger">

                                                خروج

                                            </span>

                                        @endif


                                    </td>



                                    <td>

                                        {{ $movement->quantity }}

                                    </td>



                                    <td>

                                        {{ $movement->created_at->format('Y-m-d H:i') }}

                                    </td>


                                </tr>


                            @endforeach


                        </tbody>


                    </table>


                </div>


            </div>


        </div>





    </div>


@endsection