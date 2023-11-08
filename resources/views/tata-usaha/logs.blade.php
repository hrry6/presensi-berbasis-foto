@extends('layout.layout')
@section('judul', 'Logs')
@section('sidenav')
    <nav id="sidebarMenu" class=" d-lg-block sidebar collapse bg-white">
        <div class="position-sticky">
            <div class="list-group list-group-flush mx-3 mt-4">
                <a href="/tata-usaha/dashboard" class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4" aria-current="true">
                    <img src="{{ asset('img/icon_Home.svg')}}" alt=""><span>Dashboard</span>
                </a>
                <a href="/tata-usaha/akun-guru" class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4">
                    <img src="{{ asset('img/icon_Profile.svg')}}" alt=""><span>Akun Guru</span>
                </a>
                <a href="/tata-usaha/akun-pengurus-kelas" class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4">
                    <img src="{{ asset('img/icon_Profile.svg')}}" alt=""><span>Akun Pengurus Kelas</span>
                </a>
                <a href="/tata-usaha/akun-siswa" class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4">
                    <img src="{{ asset('img/icon_Profile.svg')}}" alt=""><span>Akun Siswa</span>
                </a>
                <a href="/tata-usaha/presensi" class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4">
                    <img src="{{ asset('img/icon_Location.svg')}}" alt=""><span>Presensi</span>
                </a>
                <a href="/tata-usaha/logs" class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4  active">
                    <img src="{{ asset('img/icon_Book_White.svg')}}" alt=""><span>Logs</span>
                </a>
            </div>
        </div>
    </nav>
@endsection
@section('isi')
    <div class="mt-4 ml-4 pt-3 container-md bg-white">
        <div class="d-flex width-full justify-content-between mb-3">
            <form action="">
                <div class="input-group">
                    <input type="text" class="form-control" name="keyword" placeholder="Search Logs....">
                    <div class="input-group-append">
                      <button class="input-group-text bg-primary">
                        <img src="/img/icon_Search.svg" alt="">
                      </button>
                    </div>
                  </div>
            </form>
            <div>
                <button class="btn btn-warning" id="checkAll">Select All</button>
                <button class="btn btn-danger" id="submitFormButton">Delete</button>
            </div>
        </div>
        <form action="hapus-logs" method="post" id="hapus">
            <table class="table table-bordered DataTable">
                <thead class="thead table-dark">
                    <tr class="">
                        <th scope="col">No</th>
                        <th scope="col">Tabel</th>
                        <th scope="col">Aktor</th>
                        <th scope="col">Tanggal </th>
                        <th scope="col">Jam</th>
                        <th scope="col">Aksi</th>
                        <th scope="col">Record</th>
                        <th scope="col">Select</th>
                    </tr>
                </thead>
                @csrf
                <tbody>
                    @foreach ($logs as $i)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $i->tabel }}</td>
                        <td>{{ $i->aktor }}</td>
                        <td>{{ $i->tanggal }}</td>
                        <td>{{ $i->jam }}</td>
                        <th>{{ $i->aksi }}</th>
                        <th>{{ $i->record }}</th>
                        <th class="flex justify-center items-center">
                            <input class="checkbox" type="checkbox" name="id_logs[]" value="{{$i->id_log}}">
                        </th>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </form>

    </div>

    <script>

    </script>
@endsection

@section('footer')
    <script type="module">
        document.getElementById('checkAll').addEventListener('click', function () {
            var checkboxes = document.querySelectorAll('.checkbox');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = !checkboxes[i].checked;
            }
        });
        document.getElementById('submitFormButton').addEventListener('click', function() {
            var formElement = document.getElementById('hapus');
            formElement.submit();
        });
    </script>
@endsection
