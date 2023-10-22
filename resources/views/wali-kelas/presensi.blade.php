@extends('layout.layout')
@section('judul', 'Dashboard Wali Kelas')
@section('sidenav')
    <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
        <div class="position-sticky">
            <div class="list-group list-group-flush mx-3 mt-4">
                <a href="#" class="list-group-item list-group-item-action py-2 ripple" aria-current="true">
                    <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>Dashboard</span>
                </a>
                <a href="{{ url('wali-kelas/akun-pengurus-kelas') }}"
                    class="list-group-item list-group-item-action py-2 ripple">
                    <i class="fas fa-chart-area fa-fw me-3"></i><span>Akun Pengurus Kelas</span>
                </a>
                <a href="#" class="list-group-item list-group-item-action py-2 ripple">
                    <i class="fas fa-chart-area fa-fw me-3"></i><span>Akun Siswa</span>
                </a>
                <a href="#" class="list-group-item list-group-item-action py-2 ripple active">
                    <i class="fas fa-chart-area fa-fw me-3"></i><span>Presensi</span>
                </a>
                <a href="#" class="list-group-item list-group-item-action py-2 ripple">
                    <i class="fas fa-chart-area fa-fw me-3"></i><span>Logs</span>
                </a>
            </div>
        </div>
    </nav>
@endsection
@section('isi')

    <div class="mt-4 ml-4 pt-3 container-md bg-white">
        <div class="d-flex width-full justify-content-between mb-3">
            <form action="">
                <input type="text" placeholder="Search Siswa">
                <button class="position-relative">Search</button>
            </form>
        </div>
        <table class="table table-bordered DataTable">
            <thead class="thead table-dark">
                <tr class="">
                    <th scope="col">No</th>
                    <th scope="col">NIS</th>
                    <th scope="col">Nama Lengkap</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Kelas</th>
                    <th scope="col">Kehadiran</th>
                    <th scope="col">Foto Bukti</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($presensi as $i)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $i->nis }}</td>
                        <td>{{ $i->nama_siswa }}</td>
                        <td>{{ $i->tanggal }}</td>
                        <th>{{ $i->tingkatan . ' ' . $i->nama_jurusan . ' ' . $i->nama_kelas }}</th>
                        <td>{{ $i->status_kehadiran }}</td>
                        <td>
                            @if ($i->foto_bukti)
                                <img src="{{ url('foto') . '/' . $i->foto_bukti }} " style="max-width: 100px; height: auto;"
                                    alt="Bukti" />
                            @endif
                        </td>
                        <td>{{ $i->keterangan_lebih_lanjut }}</td>
                        <td>
                            <a href="edit-presensi-siswa/{{ $i->id_presensi }}" class="btn btn-success">EDIT</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

@endsection
