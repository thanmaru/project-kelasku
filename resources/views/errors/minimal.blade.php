<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Fonts -->
        @include('layouts.dev.link')
    </head>
    <body>
        <div class="container-scroller" style="margin-top: 10%">
        <div class="container-fluid">
          <div class="row justify-content-center align-items-center">
            <div class="content-wrapper full-page-wrapper d-flex align-items-center text-center error-page">
              <div class="col-lg-6 mx-auto">
                <h1 class="display-1 mb-0 text-primary fw-bold">@yield('code')</h1>
                <h2>@yield('message')</h2>
                <a class="btn btn-primary btn-rounded btn-lg mt-2" href="{{url('/')}}">Back to home</a>
              </div>
            </div>
          </div>
        </div>
      </div>
        @include('layouts.dev.script')
    </body>
</html>
