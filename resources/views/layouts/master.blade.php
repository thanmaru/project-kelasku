<!DOCTYPE html>
<html lang="en">

<head>
    
    <!-- Meta -->
    @include('layouts.dev.meta')

    <title>Kelasku</title>

    <!-- Styles -->
    @include('layouts.dev.link')
</head>

<body>
    @include('sweetalert::alert')

    <div class="wrapper">

        <div class="main">

            <!-- Header -->
            @include('layouts.component.topbar')
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