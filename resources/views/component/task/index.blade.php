@extends('layouts.app')

@section('content')
<main class="content">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-12">
                @if(count($content) == 0)
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-muted text-center m-0">Tidak ada Tugas</h3>
                    </div>
                </div>
                @endif
                @foreach($content as $key => $value )
                <div class="card">
                    <div class="card-header bg-blue-dark">
                        @if($value->classroom_owner == Auth::user()->id || $value->created_by == Auth::user()->id)
                        <div class="float-right">
                            <div class="btn-group ml-3">
                                <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="align-middle text-white" data-feather="menu"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                <button class="dropdown-item" type="button"><a class="dropdown-item" href="{{route('test.submission', [$value->classroom_code, $value->id])}}">Pengumpulan</a></button>
                                <button class="dropdown-item" type="button"><a onclick="return confirm('Yakin ingin menghapus?');" class="dropdown-item" href="{{route('test.delete', [$value->classroom_code, $value->id])}}">Hapus</a></button>
                                </div>
                            </div>
                        </div>
                        @endif
                        <p class="float-right text-white mb-0"><i class="align-middle" data-feather="calendar"></i>&nbsp;{{\Carbon\Carbon::parse($value->created_at)->translatedFormat('D, d M Y')}}</p>
                        <h4 class="card-title mb-0 text-white">
                            @if($value->type == 'ASSIGNMENT')
                            <i class="align-middle" data-feather="pen-tool"></i>
                            @else
                            <i class="align-middle" data-feather="globe"></i>
                            @endif
                            &nbsp; ({{$value->classroom_subject}} - {{$value->classroom_name}}) {{$value->name}} 
                        </h4>
                    </div>
                    <div class="card-body">
                        @if($value->type == 'ASSIGNMENT')
                        <p>{!! $value->description !!}</p>
                        @endif
                        @if($value->submission_status == 'LATE')
                        <p class="text-danger float-right">Dikerjakan Terlambat</p>
                        @endif
                        <p class="text-success"><i class="align-middle" data-feather="user"></i>&nbsp; {{$value->created_name}}</p>
                        @if($value->due_date)
                        <p class="text-warning"><i class="align-middle" data-feather="clock"></i>&nbsp; {{\Carbon\Carbon::parse($value->due_date)->translatedFormat('D, d M Y - H:m')}}</p>
                        @endif
                        @if($value->type == 'ASSIGNMENT')
                            @if($value->submission_id)
                            <button class="btn btn-success float-right ml-2">Nilai : {{round($value->submission_score)}}</button>
                            @endif
                        <a href="{{route('test', [$value->classroom_code, $value->id])}}" class="btn btn-primary float-right">Masuk</a>
                        @else
                        <a href="{{route('announcement', [$value->classroom_code, $value->id])}}" class="btn btn-primary float-right">Lihat</a>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</main>
@endsection
