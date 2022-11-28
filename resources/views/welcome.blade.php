@extends('layouts.app')

@section('content')
<main class="content">
    <div class="container-fluid p-0">
        <div class="row mb-3">
            <div class="col-12">
                <h4><a class="font-weight-bold text-decoration-none" href="{{route('tasklist')}}"><i class="align-middle" data-feather="list"></i> <span class="align-middle text-decoration-none">&nbsp;Daftar Tugas</a></h4>
            </div>
        </div>
        <div class="row">
            @foreach($class as $key => $value)
            <div class="col-lg-4">
                <div class="card card-box">
                    <div class="card-header bg-blue-dark">
                        @if($value->owner != Auth::user()->id)
                        <div class="dropdown float-right ">
                            <a type="button" id="dropdownMenuTestButton" data-bs-toggle="dropdown" aria-expanded="false"><i class="align-middle text-white" data-feather="menu"></i></a>
                            <ul class="dropdown-menu dropdown-menu-right mt-5" aria-labelledby="dropdownMenuTestButton">
                                <li><a class="dropdown-item" href="{{route('classroom.leave', [$value->id])}}" onclick="event.preventDefault();
                                    document.getElementById('leave-form').submit();">Keluar</a></li>
                                <form id="leave-form" action="{{ route('classroom.leave', [$value->id]) }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </ul>
                        </div>
                        @endif
                        <h3 class="mb-0 text-white text-decoration-none">{{$value->subject}}</h3>
                    </div>
                    <div class="card-body">
                        <h3 class="mt-1 mb-3 font-weight-bold">
                            <a class="text-decoration-none" href="{{route('classroom', [$value->code])}}">
                                {{$value->name}}
                            </a>
                        </h3>
                        <div class="mb-1">
                            <i class="align-middle" data-feather="user"></i> <span class="align-middle text-decoration-none">&nbsp;{{$value->count}} Anggota</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</main>
<style type="text/css">
    .card-box {
        transition: box-shadow .3s;
    }
    .card-box:hover {
      box-shadow: 10px 10px 10px #eee; 
    }
    .card-box .card-body h3 a {
        color: #6c757d;
    }
    .card-box .card-body h3 a:hover {
        color: #3b7ddd;
        transition: .3s
    }
</style>
@endsection
