@extends('layouts.app')

@section('content')
<main class="content">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-blue-dark">
                        <h5 class="card-title mb-0 text-white">Tugas</h5>
                    </div>
                    <div class="card-body">
                        <h1 class="mt-1 mb-3 text-primary">{{$content->name}}</h1>
                        <p class="text-success"><i class="align-middle" data-feather="user"></i>&nbsp; {{$content->created_name}}</p>
                        <div class="mb-3">
                            {!! $content->description !!}
                        </div>
                        @if($content->submission)
                        <div class="float-right text-right">
                            <button class="btn btn-success font-weight-bold">Nilai : {{round($content->submission->score)}}</button>
                            @if($content->submission->status == 'LATE')
                            <p class="text-danger font-weight-bold">Dikerjakan Terlambat!</p>
                            @endif
                        </div>
                        @else
                        <a href="{{route('test.start', [$class->code, $content->id])}}" class="btn btn-primary float-right">Mulai</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection