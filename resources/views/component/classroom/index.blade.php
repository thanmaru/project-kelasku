@extends('layouts.app')

@section('content')
<main class="content">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-12">
                <div class="card bg-blue-dark">
                    <div class="card-body">
                        <h5 class="card-title mb-4 text-primary">{{$class->subject}}</h5>
                        <h3 class="mt-1 mb-3 float-right text-primary">#{{$class->code}}</h3>
                        <h1 class="mt-1 mb-3 text-white">{{$class->name}}</h1>
                        <div class="mb-3">
                            @if($class->owner == Auth::user()->id)
                            <div class="dropdown float-right">
                              <button class="btn btn btn-outline-primary dropdown-toggle" type="button" id="    dropdownPostingButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="align-middle" data-feather="send"></i>&nbsp; Posting
                              </button>
                              <div class="dropdown-menu dropdown-menu-right mt-5" aria-labelledby="dropdownPostingButton">
                                <li><a type="modal" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#createExamModal">Soal</a></li>
                                <li><a type="modal" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#createAnnouncementModal">Pengumuman</a></li>
                                <li><a type="modal" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#createUploadModal">Upload</a></li>
                              </div>
                            </div>
                            @endif
                            <a type="button" class="text-decoration-none text-primary" data-bs-toggle="modal" data-bs-target="#memberModal">
                                <i class="align-middle" data-feather="user"></i>&nbsp;<span class="align-middle">{{$class->count}}</span>
                            </a>
                        </div>
                        <p class="text-white">Keterangan Kelas : <br>{{$class->description}}</p>
                    </div>
                </div>
                @if(count($content) == 0)
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-muted text-center m-0">Pengajar belum mengupload apapun</h3>
                    </div>
                </div>
                @endif
                @foreach($content as $key => $value )
                <div class="card">
                    <div class="card-header bg-blue-dark">
                        @if($class->owner == Auth::user()->id || $value->created_by == Auth::user()->id)
                        <div class="float-right">
                          <div class="btn-group ml-3">
                            <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="align-middle text-white" data-feather="menu"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                              <button class="dropdown-item" type="button"><a class="dropdown-item" href="{{route('test.submission', [$class->code, $value->id])}}">Pengumpulan</a></button>
                              <button class="dropdown-item" type="button"><a onclick="return confirm('Yakin ingin menghapus?');" class="dropdown-item" href="{{route('test.delete', [$class->code, $value->id])}}">Hapus</a></button>
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
                            &nbsp; {{$value->name}}
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
                        <a href="{{route('test', [$class->code, $value->id])}}" class="btn btn-primary float-right">Masuk</a>
                        @else
                        <a href="{{route('announcement', [$class->code, $value->id])}}" class="btn btn-primary float-right">Lihat</a>
                        @endif
                    </div>
                </div>
                @endforeach
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
                Pemilik Kelas : {{\App\User::where('id', $class->owner)->value('name')}} @if($class->owner == \Auth::user()->id) (Kamu) @endif
            </div>
        </div>
        <div style="max-height: 300px; overflow-y: auto;">
            <?php
                $member = \App\Model\Member::join('users','users.id','=','members.user_id')->where('members.classroom_id', $class->id)->where('members.user_id','!=',$class->owner)->select('members.*','users.name')->get();
            ?>
            @if(count($member) != 0)
                @foreach($member as $key => $value)
                <div class="card-body">
                    @if($class->owner == \Auth::user()->id)
                    <a href="" class="float-right text-decoration-none text-danger"><i class="align-middle" data-feather="delete"></i></a>
                    @endif
                    {{$value->name}} @if($value->user_id == \Auth::user()->id) (Kamu) @endif
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

<!-- Modal -->
<div class="modal fade" id="createExamModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tugas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="row" id="create-test-form" method="GET" action="{{route('test.create', [$class->code])}}">
            <div class="form-group col-md-6">
                <label for="count">Jumlah Soal</label>
                <input type="number" name="quest" class="form-control" placeholder="Masukan Jumlah Soal" required="">
            </div>
            <div class="form-group col-md-6">
                <label for="option">Jumlah Pilihan Ganda</label>
                <input type="number" name="option" class="form-control" placeholder="Masukan Jumlah Pilihan" required="">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <a href="" class="btn btn-primary" onclick="event.preventDefault();
                        document.getElementById('create-test-form').submit();">Buat</a>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="createAnnouncementModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-blue-dark">
        <h4 class="modal-title text-white" id="exampleModalLabel">Pengumuman</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="create-announcement-form" method="POST" action="{{route('announcement.save', [$class->id])}}">
            @csrf
            <div class="form-group mb-3">
                <label for="count">Judul</label>
                <input type="text" name="name" class="form-control form-control-lg" placeholder="Masukan Judul" required>
            </div>
            <div class="form-group">
                <label for="option">Deskripsi Pengumuman</label>
                <textarea id="editor" name="description"></textarea>
            </div>
        </form>
      </div>
      <div class="modal-footer bg-blue-dark">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <a href="" class="btn btn-primary" onclick="event.preventDefault();
                        document.getElementById('create-announcement-form').submit();">Simpan</a>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="createUploadModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-blue-dark">
          <h4 class="modal-title text-white" id="exampleModalLabel">Upload File</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="create-upload-form" method="POST" action="" enctype="multipart/form-data">
            <div class="form-group mb-3">
                <label for="count">Judul</label>
                <input type="text" name="name" class="form-control form-control-lg" placeholder="Masukan Judul" required>
            </div>
            <div class="form-group">
                <label for="option">Deskripsi</label>
                <textarea id="editor" name="description"></textarea>
            </div>
            <div class="form-group">   
                <b>File Upload</b> <input type="file" name="NamaFile">
                <input type="submit" name="proses" value="Upload">
            </div>
        </form>
      </div>
      <div class="modal-footer bg-blue-dark">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <a href="" class="btn btn-primary" onclick="event.preventDefault();
                        document.getElementById('create-upload-form').submit();">Submit</a>
      </div>
    </div>
  </div>
</div>
@endsection
