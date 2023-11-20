@extends('layout.layout')
@section('judul', 'Presensi')
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
                    class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4">
                    <img src="{{ asset('img/icon_Profile.svg') }}" alt=""><span>Siswa</span>
                </a>
                <a href="{{ url('wali-kelas/presensi-siswa') }}"
                    class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4 active">
                    <img src="{{ asset('img/icon_Location_White.svg') }}" alt=""><span>Presensi</span>
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
        <form class="flex gap-3 flex-col w-auto mb-3" action="" method="get" id="form">
            <div class="flex justify-content-between">
                <div class="flex">
                    <input type="text" class="form-control" style="width:200px !important" name="keyword"
                        value="{{ old('keyword', request('keyword')) }}" placeholder="Search Presensi....">
                    <div class="input-group-append mx-2">
                        <button class="input-group-text bg-primary">
                            <img src="/img/icon_Search.svg" alt="">
                        </button>
                    </div>
                </div>
                <button class="btn btn-success" id="downloadPDF">Download PDF</button>
            </div>
            <div class="flex gap-3 w-50">
                <input type="date" class="form-control filter" id="tanggal"
                    value="{{ old('filter_tanggal', request('filter_tanggal')) }}" name="filter_tanggal"
                    placeholder="Pilih Tanggal">
                <select class="form-select filter" name="filter_kehadiran" value="">
                    <option value=""
                        {{ old('filter_kehadiran', request('filter_kehadiran')) == '' ? 'selected' : '' }}>
                        Pilih Status Kehadiran</option>
                    <option value="hadir"
                        {{ old('filter_kehadiran', request('filter_kehadiran')) == 'hadir' ? 'selected' : '' }}>Hadir
                    </option>
                    <option value="alpha"
                        {{ old('filter_kehadiran', request('filter_kehadiran')) == 'alpha' ? 'selected' : '' }}>Alpha
                    </option>
                    <option value="izin"
                        {{ old('filter_kehadiran', request('filter_kehadiran')) == 'izin' ? 'selected' : '' }}>Izin
                    </option>
                </select>
            </div>
        </form>
        <table class="table table-bordered">
            <thead class="thead table-dark">
                <tr class="">
                    <th scope="col">No</th>
                    <th scope="col">Nis</th>
                    <th scope="col">Nama Siswa</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Kelas</th>
                    <th scope="col">Kehadiran</th>
                    <th scope="col">Foto Bukti</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($presensi as $p)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $p->nis }}</td>
                        <td>{{ $p->nama_siswa }}</td>
                        <td>{{ $p->tanggal }}</td>
                        <td>{{ $p->tingkatan . ' ' . $p->nama_jurusan . ' ' . $p->nama_kelas }}</td>
                        <td>{{ $p->status_kehadiran }}</td>
                        <td>
                            <img src="{{ url('presensi_bukti') . '/' . $p->foto_bukti }} "
                                style="max-width: 100px; height: auto;" alt="Bukti" />
                        </td>
                        <td>{{ $p->keterangan }}</td>
                        <td class="d-flex justify-content-around align-items-center">
                            <a href="/wali-kelas/detail-presensi-siswa/{{ $p->id_presensi }}" class="mx-2">
                                <img src="{{ asset('img/icon_Vector.svg') }}" alt="">
                            </a>
                            <a href="/wali-kelas/edit-presensi-siswa/{{ $p->id_presensi }}">
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
        $('#downloadPDF').on('click', function(e) {
            $("#form").attr('action', '/wali-kelas/presensi-pdf').submit();
        })
    </script>
@endsection
