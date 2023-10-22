@extends('layout.layout')
@section('judul', 'Dashboard Wali Kelas')
<style>
    .block {
        padding: 100px;
        text-align: center;
        border-radius: 20px
    }

    .color-text {
        color: #F9812A;
    }
</style>
@section('sidenav')
    <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
        <div class="position-sticky">
            <div class="list-group list-group-flush mx-3 mt-4">
                <a href="{{ url('wali-kelas/dashboard') }}" class="list-group-item list-group-item-action py-2 ripple active"
                    aria-current="true">
                    <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>Dashboard</span>
                </a>
                <a href="{{ url('wali-kelas/akun-pengurus-kelas') }}"
                    class="list-group-item list-group-item-action py-2 ripple">
                    <i class="fas fa-chart-area fa-fw me-3"></i><span>Akun Pengurus Kelas</span>
                </a>
                <a href="{{ url('wali-kelas/akun-siswa') }}"class="list-group-item list-group-item-action py-2 ripple">
                    <i class="fas fa-chart-area fa-fw me-3"></i><span>Akun Siswa</span>
                </a>
                <a href="{{ url('wali-kelas/presensi-siswa') }}" class="list-group-item list-group-item-action py-2 ripple">
                    <i class="fas fa-chart-area fa-fw me-3"></i><span>Presensi</span>
                </a>
                <a href="{{ url('wali-kelas/logs') }}" class="list-group-item list-group-item-action py-2 ripple">
                    <i class="fas fa-chart-area fa-fw me-3"></i><span>Logs</span>
                </a>
            </div>
        </div>
    </nav>
@endsection
@section('isi')
    <div class="container mt-1 mx-5">
        <div class="row">
            <div class="col-sm-4 mb-5 mx-5">
                <div class="block bg-white">
                    <div class="fs-1 color-text fw-bold">{{ $totalStudents }}</div>
                    <span class="fs-3 text-nowrap">Jumlah Siswa</span>
                </div>
            </div>
            <div class="col-sm-4 mb-5 mx-5">
                <div class="block bg-white">
                    <div class="fs-1 color-text fw-bold">{{ $totalHadir }}</div>
                    <span class="fs-3 text-nowrap">Jumlah Hadir</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4 mb-5 mx-5">
                <div class="block bg-white">
                    <span class="fs-1 color-text fw-bold">{{ $totalIzin }}</span>
                    <span class="fs-3 text-nowrap">Jumlah Sakit/Izin</span>
                </div>
            </div>
            <div class="col-sm-4 mb-5 mx-5">
                <div class="block bg-white">
                    <span class="fs-1 color-text fw-bold">{{ $totalAlpha }}</span>
                    <span class="fs-3 text-nowrap">Jumlah Tidak Hadir</span>
                </div>
            </div>
        </div>
    </div>
@endsection
