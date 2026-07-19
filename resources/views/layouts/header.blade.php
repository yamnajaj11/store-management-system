<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow">

    <div class="container-fluid px-4">


        {{-- Logo --}}

        <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('dashboard') }}">


            <div class="bg-primary rounded-3 p-2 me-2">

                <i class="bi bi-shop fs-4 text-white"></i>

            </div>


            <span class="fs-5">

                {{ __('layout.app_name') }}

            </span>


        </a>





        {{-- Toggle Mobile --}}

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu"
            aria-controls="navbarMenu" aria-expanded="false" aria-label="تبديل القائمة">


            <span class="navbar-toggler-icon"></span>


        </button>







        <div class="collapse navbar-collapse" id="navbarMenu">



        </div>



    </div>

</nav>