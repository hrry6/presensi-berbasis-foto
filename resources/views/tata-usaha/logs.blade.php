@extends('layout.layout')
@section('judul', 'Logs')
@section('sidenav')
    <nav id="sidebarMenu" class=" d-lg-block sidebar collapse bg-white">
        <div class="position-sticky">
            <div class="list-group list-group-flush mx-3 mt-4">
                <a href="/tata-usaha/dashboard" class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4" aria-current="true">
                    <img src="{{ asset('img/icon_Home.svg')}}" alt=""><span>Dashboard</span>
                </a>
                <a href="/tata-usaha/jurusan" class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4" aria-current="true">
                    <img src="{{ asset('img/icon_Home.svg')}}" alt=""><span>Jurusan</span>
                </a>
                <a href="/tata-usaha/kelas" class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4" aria-current="true">
                    <img src="{{ asset('img/icon_Home.svg')}}" alt=""><span>Kelas</span>
                </a>
                <a href="/tata-usaha/akun-guru" class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4">
                    <img src="{{ asset('img/icon_Profile.svg')}}" alt=""><span>Guru</span>
                </a>
                <a href="/tata-usaha/akun-pengurus-kelas" class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4">
                    <img src="{{ asset('img/icon_Profile.svg')}}" alt=""><span>Pengurus Kelas</span>
                </a>
                <a href="/tata-usaha/akun-siswa" class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4">
                    <img src="{{ asset('img/icon_Profile.svg')}}" alt=""><span>Siswa</span>
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
        <div class="flex gap-3 flex-col w-auto mb-3">
            <div class=" flex w-full justify-content-between">
                <form action="">
                    <div class="flex">
                        <input type="text" class="form-control" style="width:200px !important" name="keyword" value="{{ old('keyword', request('keyword')) }}" placeholder="Search Logs....">
                        <div class="input-group-append">
                            <button class="input-group-text bg-primary" > 
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
            <form action="" method="get" id="form">
                <div class="flex gap-3">
                    <select class="form-select filter" name="filter_tabel" value="">
                        <option value="" {{ old('filter_tabel', request('filter_tabel'))==""?"selected" : "" }}>Pilih Tabel</option>
                        <option value="guru" {{ old('filter_tabel', request('filter_tabel'))=="guru"?"selected" : "" }}>Guru</option>
                        <option value="siswa" {{ old('filter_tabel', request('filter_tabel'))=="siswa"?"selected" : "" }}>Siswa</option>
                        <option value="pengurus-kelas" {{ old('filter_tabel', request('filter_tabel'))=="pengurus_kelas"?"selected" : "" }}>Pengurus Kelas</option>
                    </select>
                    <select class="form-select filter" name="filter_aktor" value="">
                        <option value="" {{ old('filter_aktor', request('filter_aktor'))==""?"selected" : "" }}>Pilih Aktor</option>
                        <option value="Tata Usaha" {{ old('filter_aktor', request('filter_aktor'))=="Tata Usaha"?"selected" : "" }}>Tata Usaha</option>
                        <option value="Wali Kelas" {{ old('filter_aktor', request('filter_aktor'))=="Wali Kelas"?"selected" : "" }}>Wali Kelas</option>
                        <option value="Guru Piket" {{ old('filter_aktor', request('filter_aktor'))=="Guru Piket"?"selected" : "" }}>Guru Piket</option>
                        <option value="Guru BK" {{ old('filter_aktor', request('filter_aktor'))=="Guru BK"?"selected" : "" }}>Guru BK</option>
                        <option value="Pengurus Kelas" {{ old('filter_aktor', request('filter_aktor'))=="Guru BK"?"selected" : "" }}>Pengurus Kelas</option>
                        <option value="Siswa" {{ old('filter_aktor', request('filter_aktor'))=="Siswa"?"selected" : "" }}>Siswa</option>
                    </select>
                    <input type="date" class="form-control filter" id="tanggal" value="{{ old('filter_tanggal', request('filter_tanggal'))}}" name="filter_tanggal" placeholder="Pilih Tanggal">
                    <select class="form-select filter" name="filter_aksi" value="">
                        <option value="" {{ old('filter_aksi', request('filter_aksi'))==""?"selected" : "" }}>Pilih Aksi</option>
                        <option value="Tambah" {{ old('filter_aksi', request('filter_aksi'))=="Tambah"?"selected" : "" }}>Tambah</option>
                        <option value="Edit" {{ old('filter_aksi', request('filter_aksi'))=="Edit"?"selected" : "" }}>Edit</option>
                        <option value="Hapus" {{ old('filter_aksi', request('filter_aksi'))=="Hapus"?"selected" : "" }}>Hapus</option>
                    </select>
                </div>
            </form>
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
        $(".filter").on('change', function() {
            $("#form").submit();
        })
    </script>
@endsection
