@extends('layouts.master')

@section('content')
<main class="content">
    <div class="container-fluid p-0">

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card flex-fill w-100">
                    <div class="card-header bg-blue-dark">
                        <h5 class="card-title text-white mb-0">Soal : {{$test->name}}</h5>
                    </div>
                    <div class="card-body py-0">
                        <div class="row">
                            <div class="col-sm-12">
                                <form class="row justify-content-center" method="POST" action="{{route('test.submit', [$class->code, $test->id])}}">
                                @csrf
                                    @foreach($quest as $key => $value)
                                    <div class="card-body">
                                        <div class="form-group col-md-12">
                                            <h4>{!! $value->quest !!}</h4>
                                            @foreach(\App\Model\Option::where('quest_id', $value->id)->get() as $keys => $values)
                                            <input type="hidden" value="{{$value->id}}" name="option[{{$key}}][quest_id]">
                                            <div class="form-check">
                                                <input class="form-check-input" value="{{$values->id}}" type="radio" name="option[{{$key}}][answer]" id="flexRadioDefault">
                                                <label class="form-check-label" for="flexRadioDefault">
                                                    {{$values->name}}
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endforeach
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-lg float-right">Submit</button>
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
@endsection
