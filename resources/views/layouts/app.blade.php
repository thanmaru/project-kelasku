<!DOCTYPE html>
<html lang="en">

<head>
    
    <!-- Meta -->
    @include('layouts.dev.meta')
    <link rel="shortcut icon" href="{{asset('/assets/img/favicon.ico')}}" type="image/x-icon">
    <title>Kelasku</title>

    <!-- Styles -->
    @include('layouts.dev.link')
</head>

<body>
    @include('sweetalert::alert')

    <div class="wrapper">

        <!-- Sidebar -->
        @include('layouts.component.sidebar')
        <!-- End Sidebar -->

        <div class="main">

            <!-- Header -->
            @include('layouts.component.header')
            <!-- End Header -->

            @yield('content')

            <!-- Footer -->
            @include('layouts.component.footer')
            <!-- End Footer -->

        </div>
    </div>

</body>

<!-- Script -->
@include('layouts.dev.script')

</html>