@extends('layout.layout')
@section('judul', 'Siswa')
@section('sidenav')
    <nav id="sidebarMenu" class="collapse d-lg-block sidebar bg-white">
        <div class="position-sticky">
            <div class="list-group list-group-flush mx-3 mt-4">
                <a href="{{ url('wali-kelas/dashboard') }}"
                    class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4" aria-current="true">
                    <img src="{{ asset('img/icon_Home.svg') }}" alt=""><span>Dashboard</span>
                </a>
                <a href="{{ url('wali-kelas/akun-pengurus-kelas') }}"
                    class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4">
                    <img src="{{ asset('img/icon_Profile.svg') }}" alt=""><span>Pengurus Kelas</span>
                </a>
                <a href="{{ url('wali-kelas/akun-siswa') }}"
                    class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4 active">
                    <img src="{{ asset('img/icon_Profile.svg') }}" alt=""><span>Siswa</span>
                </a>
                <a href="{{ url('wali-kelas/presensi-siswa') }}"
                    class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4">
                    <img src="{{ asset('img/icon_Location.svg') }}" alt=""><span>Presensi</span>
                </a>
                <a href="{{ url('wali-kelas/logs') }}"
                    class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4">
                    <img src="{{ asset('img/icon_Book.svg') }}" alt=""><span>Logs</span>
                </a>
            </div>
        </div>
    </nav>
@endsection
@section('isi')
    <div class="mt-4 ml-4 pt-3 container-md bg-white">
        <form action="" method="get" class="flex gap-3 flex-col w-auto mb-3" id="form">
            <div class=" flex w-full justify-content-between">
                <div class="flex">
                    <input type="text" class="form-control" style="width:200px !important" name="keyword"
                        value="{{ old('keyword', request('keyword')) }}" placeholder="Search Siswa....">
                    <div class="input-group-append mx-2">
                        <button class="input-group-text bg-primary">
                            <img src="/img/icon_Search.svg" alt="">
                        </button>
                    </div>
                </div>
            </div>
            <div class="flex gap-3 w-25">
                <select class="form-select filter" name="filter_jenkel" value="">
                    <option value="" {{ old('filter_jenkel', request('filter_jenkel')) == '' ? 'selected' : '' }}>
                        Pilih
                        Jankel</option>
                    <option value="laki-laki"
                        {{ old('filter_jenkel', request('filter_jenkel')) == 'laki_laki' ? 'selected' : '' }}>Laki-laki
                    </option>
                    <option value="perempuan"
                        {{ old('filter_jenkel', request('filter_jenkel')) == 'perempuan' ? 'selected' : '' }}>Perempuan
                    </option>
                </select>
            </div>
        </form>
        <table class="table table-bordered DataTable">
            <thead class="thead table-dark">
                <tr class="">
                    <th scope="col">No</th>
                    <th scope="col">Foto</th>
                    <th scope="col">NIS</th>
                    <th scope="col">Nama Lengkap</th>
                    <th scope="col">Jenkel</th>
                    <th scope="col">Kelas</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($siswa as $i)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if ($i->foto_siswa)
                                <img src="{{ url('siswa') . '/' . $i->foto_siswa }} "
                                    style="max-width: 100px; height: auto;" alt="Profile" />
                            @endif
                        </td>
                        <td>{{ $i->nis }}</td>
                        <td>{{ $i->nama_siswa }}</td>
                        <td>{{ $i->jenis_kelamin }}</td>
                        <th>{{ $i->tingkatan . ' ' . $i->nama_jurusan . ' ' . $i->nama_kelas }}</th>
                        <td class="d-flex justify-content-around align-items-center">
                            <a href="/wali-kelas/detail-siswa/{{ $i->id_siswa }}">
                                <img src="{{ asset('img/icon_Vector.svg') }}" alt="">
                            </a>
                            <a href="/wali-kelas/edit-siswa/{{ $i->id_siswa }}">
                                <img src="{{ asset('img/icon_Edit.svg') }}" alt="">
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('footer')
    <script type="module">
        $(".filter").on('change', function() {
            $("#form").submit();
        })
    </script>
@endsection
