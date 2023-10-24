@extends('layout.layout')
@section('judul', 'Presensi')
@section('sidenav')
    <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
        <div class="position-sticky">
            <div class="list-group list-group-flush mx-3 mt-4">
                <a href="/tata-usaha/dashboard" class="list-group-item list-group-item-action py-2 ripple" aria-current="true">
                    <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>Dashboard</span>
                </a>
                <a href="/tata-usaha/presensi" class="list-group-item list-group-item-action py-2 ripple active">
                    <i class="fas fa-chart-area fa-fw me-3"></i><span>Presensi</span>
                </a>
            </div>
        </div>
    </nav>
@endsection
@section('isi')
    <div class="mt-4 ml-4 pt-3 container-md bg-white">
        <div class="d-flex width-full justify-content-between mb-3">
            <form action="">
                <input type="text" placeholder="Search Presensi">
                <button class="position-relative">Search</button>
            </form>
        </div>
        <table class="table table-bordered DataTable">
            <thead class="thead table-dark">
                <tr class="">
                    <th scope="col">No</th>
                    <th scope="col">Foto Bukti</th>
                    <th scope="col">Nama Siswa</th>
                    <th scope="col">Tanggal </th>
                    <th scope="col">Status Kehadiran</th>
                    <th scope="col">Kelas</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($presensi as $i)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $i->foto_bukti }}</td>
                        <td>{{ $i->nama_siswa }}</td>
                        <td>{{ $i->tanggal }}</td>
                        <td>{{ $i->status_kehadiran }}</td>
                        <td>{{ $i->tingkatan." ".$i->jurusan." ".$i->nama_kelas}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

@endsection