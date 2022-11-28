<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle d-flex" href="{{ url()->previous() }}">
      <i class=" align-self-center" data-feather="corner-down-left"></i>
    </a>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-toggle="dropdown">
                    <span class="text-dark">{{Auth::user()->name}}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        Log out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buat Kelas</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body m-3">
                <form method="POST" id="create-form" action="{{route('classroom.save')}}">
                @csrf
                    <div class="form-group mb-3">
                        <label class="form-label">Nama Kelas</label>
                        <input class="form-control" name="name" placeholder="Masukan Nama Kelas (wajib)" required></input>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Mata Pelajaran</label>
                        <input class="form-control" name="subject" placeholder="Masukan Mata Pelajaran Kelas (wajib)"></input>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Keterangan Kelas</label>
                        <textarea class="form-control" name="description" placeholder="Masukan Keterangan Kelas"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="event.preventDefault();
                        document.getElementById('create-form').submit();">Submit</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="joinModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gabung Kelas</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body m-3">
                <form id="join-form" method="POST" id="create-form" action="{{route('classroom.join')}}">
                @csrf
                    <div class="form-group mb-3">
                        <label class="form-label">Kode Kelas</label>
                        <input class="form-control" name="code" placeholder="Masukan Kode Kelas (wajib)" required></input>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="event.preventDefault();
                        document.getElementById('join-form').submit();">Submit</button>
            </div>
        </div>
    </div>
</div>
