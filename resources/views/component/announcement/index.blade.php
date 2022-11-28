@extends('layouts.app')

@section('content')
<main class="content">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-blue-dark">
                        <h5 class="card-title mb-0 text-white">Pengumuman</h5>
                    </div>
                    <div class="card-body">
                        <h1 class="mt-1 mb-3 text-primary">{{$content->name}}</h1>
                        <p class="text-success"><i class="align-middle" data-feather="user"></i>&nbsp; {{$content->created_name}}</p>
                        <div class="mb-3">
                            {!! $content->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection