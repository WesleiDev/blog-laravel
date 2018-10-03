<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Stellar Admin</title>


    @include('admin.layout._style')
    @yield('style')
    @stack('style')
    <!-- endinject -->
    <link rel="shortcut icon" href="images/favicon.png" />
</head>
<body>
<div class="container-scroller">
    @include('admin.layout._nav')
    <div class="container-fluid page-body-wrapper">
        <div class="row row-offcanvas row-offcanvas-right">
            <!-- partial:partials/_sidebar.html -->
            @include('admin.layout._menu')
            <!-- partial -->
            <div class="content-wrapper">
                <!-- ROW ENDS -->
                @yield('content')
                <!-- ROW ENDS -->
            </div>

            @include('admin.layout._footer')

        </div>
        <!-- row-offcanvas ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->

@include('admin.layout._script')
@yield('script')
@stack('script')
@if(Session::has('mensagem'))
    <script>
        notify("{{Session::get('mensagem')['status']}}","{{Session::get('mensagem')['msg']}}");
    </script>
@endif
</body>

</html>
