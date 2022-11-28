<?php
    $class = \App\Model\Classroom::join('members','members.classroom_id','=','classrooms.id')->where('members.user_id', \Auth::user()->id)->get();
?>
<nav id="sidebar" class="sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="{{route('home')}}">
          <img src="{{asset('/assets/img/Logo Kelasku.png')}}" style="width: 25px; height:25px;"  > <span class="align-middle">Kelasku</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Menu
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{url('/')}}"><i class="align-middle" data-feather="home"></i> <span class="align-middle">Home</span></a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{route('tasklist')}}"><i class="align-middle" data-feather="list"></i> <span class="align-middle">Daftar Tugas</span></a>
            </li>
            <li class="sidebar-item">
                <a href="#teach" data-toggle="collapse" class="sidebar-link collapsed">
                    <i class="align-middle" data-feather="book-open"></i> <span class="align-middle">Kelas</span>
                </a>
                <ul id="teach" class="sidebar-dropdown list-unstyled collapse" data-parent="#sidebar">
                    @foreach($class as $key => $value)
                        <li class="sidebar-item"><a class="sidebar-link" href="{{route('classroom', [$value->code])}}">{{$value->name}}</a></li>
                    @endforeach     
                </ul>
            </li>
        </ul>
    </div>
</nav>