@extends('layouts.app')

@section('title', 'إضافة مجموعة منتجات')

@section('content')

    <div class="container-fluid">

        <div class="bg-white p-4 shadow-sm rounded-4 border">


            <div class="d-flex justify-content-between align-items-center mb-4">

                <h4 class="mb-0 text-primary fw-bold">

                    <i class="bi bi-boxes me-2"></i>

                    إضافة مجموعة منتجات

                </h4>


                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm">

                    <i class="bi bi-arrow-left"></i>

                    رجوع

                </a>


            </div>




            <form action="{{ route('products.bulkStore') }}" method="POST">

                @csrf



                <div class="card border-0 shadow-sm mb-4">

                    <div class="card-body">


                        <label class="form-label fw-semibold">

                            المورد

                        </label>


                        <select name="supplier_id" class="form-select" required>


                            <option value="">

                                اختر المورد

                            </option>


                            @foreach($suppliers as $supplier)

                                <option value="{{ $supplier->id }}">

                                    {{ $supplier->name }}

                                </option>

                            @endforeach


                        </select>


                    </div>

                </div>





                <div class="card border-0 shadow-sm">


                    <div class="card-body">


                        <div class="d-flex justify-content-between align-items-center mb-3">


                            <h5 class="text-secondary fw-bold mb-0">

                                المنتجات

                            </h5>



                            <button type="button" class="btn btn-success btn-sm" onclick="addRow()">


                                <i class="bi bi-plus-lg"></i>

                                إضافة سطر


                            </button>


                        </div>





                        <div class="table-responsive">


                            <table class="table table-bordered text-center align-middle">


                                <thead class="table-light">

                                    <tr>

                                        <th>
                                            اسم المنتج
                                        </th>


                                        <th>
                                            الوحدة
                                        </th>


                                        <th>
                                            الوصف
                                        </th>


                                        <th>
                                            حذف
                                        </th>

                                    </tr>

                                </thead>



                                <tbody id="productsTable">


                                    <tr>


                                        <td>

                                            <input type="text" name="products[0][name]" class="form-control" required>

                                        </td>


                                        <td>

                                            <input type="text" name="products[0][unit]" class="form-control" required>

                                        </td>


                                        <td>

                                            <input type="text" name="products[0][description]" class="form-control">

                                        </td>


                                        <td>

                                            <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">

                                                <i class="bi bi-trash"></i>

                                            </button>

                                        </td>


                                    </tr>



                                </tbody>


                            </table>


                        </div>


                    </div>


                </div>






                <div class="mt-4 text-end">


                    <button class="btn btn-primary px-4">


                        <i class="bi bi-check-circle me-1"></i>

                        حفظ المنتجات


                    </button>



                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary px-4">


                        إلغاء


                    </a>


                </div>




            </form>



        </div>


    </div>




    <script>

        let index = 1;


        function addRow() {

            let row = `

        <tr>

            <td>

                <input type="text"
                       name="products[${index}][name]"
                       class="form-control"
                       required>

            </td>


            <td>

                <input type="text"
                       name="products[${index}][unit]"
                       class="form-control"
                       required>

            </td>


            <td>

                <input type="text"
                       name="products[${index}][description]"
                       class="form-control">

            </td>


            <td>

                <button type="button"
                        class="btn btn-danger btn-sm"
                        onclick="removeRow(this)">

                    <i class="bi bi-trash"></i>

                </button>

            </td>


        </tr>


        `;


            document
                .getElementById('productsTable')
                .insertAdjacentHTML('beforeend', row);


            index++;

        }



        function removeRow(button) {

            button.closest('tr').remove();

        }


    </script>



@endsection