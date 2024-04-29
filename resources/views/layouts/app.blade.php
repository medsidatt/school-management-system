@include('partials._head')

<!-- ======= Header ======= -->
@include('partials._header')
<!-- End Header -->
<!-- ======= Sidebar ======= -->
@include('partials._aside')
<!-- End Sidebar-->

<main id="main" class="main">
    @yield('content')
</main>
<!-- End #main -->

<!-- ======= Footer ======= -->
@include('partials._footer')
<!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

@include('partials._foot')
