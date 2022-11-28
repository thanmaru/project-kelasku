@extends('layouts.master')

@section('content')
<main class="content">
    <div class="container-fluid p-0">

        <div class="row justify-content-center">
            <div class="col-xl-10 col-xxl-10">
                <div class="card flex-fill w-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><h3>Buat Soal</h3></h5>
                    </div>
                    <div class="card-body py-3">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <form class="row justify-content-center">
                                        <div class="card-body">
                                            <div class="form-group col-md-12">
                                                <label>Judul Soal</label>
                                                <input type="text" name="name" class="form-control">
                                            </div>
                                            <div class="form-group col-md-12 my-2">
                                                <label>Deskripsi Soal</label>
                                                <textarea class="form-control" name="description" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <hr>
                                        @for($i = 0; $i < $test; $i++)
                                        <div class="card-body">
                                            <div class="form-group col-md-12">
                                                <label>{{$i+1}}. Soal</label>
                                                <textarea class="form-control mb-2" name="quest[]"></textarea>
                                                @for($j = 0; $j < $option; $j++)
                                                <div class="input-group mb-1">
                                                        <div class="input-group-text">
                                                            <input class="form-check-input mt-0" type="radio" name="answer{{$i}}[]" value="{{$j}}" aria-label="Radio button for following text input">
                                                        </div>
                                                    <input type="text" name="option[]" class="form-control" placeholder="Pilihan {{$j+1}}" aria-label="Text input with radio button">
                                                </div>
                                                @endfor
                                            </div>
                                        </div>
                                        @endfor
                                        <hr>
                                        <div class="card-footer">
                                            <button class="btn btn-primary btn-lg float-right">Buat</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- Modal -->
<div class="modal fade" id="memberModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Daftar Anggota Kelas {{$class->name}}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body mb-3">
        <div class="card">
        <div class="card-body text-primary">
                Pemilik Kelas : {{\App\User::where('id', $class->owner)->value('name')}}
            </div>
        </div>
        <div style="max-height: 300px; overflow-y: auto;">
            <?php
                $member = \App\Model\Member::where('classroom_id', $class->id)->get();
            ?>
            @if(count($member) != 0)
                @foreach($member as $key => $value)
                <div class="card-body">
                    @if($class->owner == \Auth::user()->id)
                    <a href="" class="float-right text-decoration-none text-danger"><i class="align-middle" data-feather="delete"></i></a>
                    @endif
                    {{\App\User::where('id', $value->user_id)->orderBy('name', 'asc')->value('name')}}
                </div>
                @endforeach
            @else
                <div class="card-body">
                    Tidak ada anggota
                </div>
            @endif
        </div>
        </div>
    </div>
  </div>
</div>
@endsection
