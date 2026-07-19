<!DOCTYPE html>
<html lang="ar" dir="rtl" translate="no">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        @yield('title', __('layout.app_name'))
    </title>


    <!-- Bootstrap RTL -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">


    <!-- Bootstrap Icons -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">


    <!-- Cairo Font -->

    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">


    <!-- Custom CSS -->

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">


</head>



<body class="bg-light text-dark" style="font-family:'Cairo',sans-serif;">



    @include('layouts.header')



    <div class="container-fluid">


        <div class="row flex-nowrap">


            @include('layouts.sidebar')



            <main class="col-md-9 col-lg-10 px-md-4 py-4">


                @yield('content')


            </main>


        </div>


    </div>



    @include('layouts.footer')




    <!-- jQuery -->

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>



    <!-- Bootstrap JS -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>



    @stack('scripts')


</body>

</html>