<!DOCTYPE html>
<html lang="en">

<head>
    
    <!-- Meta -->
    @include('layouts.dev.meta')
    <link rel="shortcut icon" href="{{asset('/assets/img/favicon.ico')}}" type="image/x-icon">
    <title>Masuk | Kelasku</title>
    

    <!-- Styles -->
    @include('layouts.dev.link')
    <style>
        .img {
            width: 200px;
            height: 200px;
            border-radius: 10px;
        }
        
        .kotak{
            color: black;
            background-color: whitesmoke;
        }
        .test{
            background-color: red;
        }
        .bg-image {

        }
    </style>
    
</head>

<body>

    
    <main class="d-flex w-100 bg-image" style="background-image: 
    url(https://pixabay.com/get/gef753edba9513cf1d43b5285d400fd6ef06a849b381df82475f1f7fab43a239906c3e64efb93f36900331b64f029e3be9d40ffd3b39ec7d2864ad72aa2b31c1b9a6ab8517a2d7063ed39fea94228ae92_1920.jpg);
    height: 100vh;">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">

                        <div class="text-center mt-4">
                            <img class="img" src="{{asset('/assets/img/Logo Kelasku.png')}}" >
                            <h1 class="h2 font-weight-bold" >Selamat Datang</h1>
                            <p class="h2 lead">
                                Silahkan Masuk untuk melanjutkan
                            </p>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-4">
                                    <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input id="email" class="form-control form-control-lg @error('email') is-invalid @enderror" type="email" name="email" placeholder="Masukan Email Anda" value="{{ old('email') }}" required autocomplete="email" autofocus/>
                                            @error('email')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <input id="password" class="form-control form-control-lg @error('password') is-invalid @enderror" type="password" name="password" placeholder="Masukan Password Anda" required autocomplete="current-password"/>
                                            @error('password')
                                            <span class="text-danger" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="form-check">
                                                <input class="form-check-input" type="checkbox" value="remember-me" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                <span class="form-check-label">
                                                  Ingat Saya
                                                </span>
                                            </label>
                                        </div>
                                        <div class="text-center mt-3">
                                            <button type="submit" class="btn btn-block btn-lg btn-primary my-3">Masuk</button>
                                            <a href="{{route('register')}}" class="text-decoration-non">Belum memiliki akun ? Register</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Script -->
    @include('layouts.dev.script')

</body>

</html>