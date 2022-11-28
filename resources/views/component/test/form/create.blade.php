@extends('layouts.app')

@section('content')
<main class="content">
    <div class="container-fluid p-0">
        <form class="row justify-content-center" method="POST" action="{{route('test.save', [$class->code])}}">
            @csrf
            <div class="col-12">
                <div class="card flex-fill w-100">
                    <div class="card-header bg-blue-dark">
                        <div class="card-title text-white mb-0">Buat Tugas</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Judul</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Tenggat Waktu</label>
                            <input type="datetime-local" name="due_date" class="form-control">
                        </div>
                        <div class="form-group my-2">
                            <label>Deskripsi</label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card">
                    @for($i = 0; $i < $quest; $i++)
                    <div class="card-body">
                        <div class="form-group col-md-12">
                            <label>{{$i+1}}. Soal</label>
                            <textarea class="form-control ckeditor" name="quest[]" required></textarea>
                            <br>
                            @for($j = 0; $j < $option; $j++)
                            <div class="input-group mb-1">
                                    <div class="input-group-text">
                                        <input class="form-check-input mt-0" type="radio" name="answer[{{$i}}]" value="{{$j}}" aria-label="Radio button for following text input" required>
                                    </div>
                                <input type="text" name="option[{{$i}}][]" class="form-control" placeholder="Pilihan {{$j+1}}" aria-label="Text input with radio button" required>
                            </div>
                            @endfor
                        </div>
                    </div>
                    @endfor
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-lg float-right">Buat</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>
@endsection
