@extends('layout.layout')
@section('judul', 'Dashboard Wali Kelas')
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
    <div class="container">
        <!-- Row 1 -->
        <div class="row">
            <div class="col-sm-4">
                <div class="block bg-white">Block 1</div>
            </div>
            <div class="col-sm-4">
                <div class="block bg-white">Block 2</div>
            </div>
            <div class="col-sm-4">
                <div class="block bg-white">Block 3</div>
            </div>
        </div>

        <!-- Row 2 -->
        <div class="row">
            <div class="col-sm-4">
                <div class="block bg-white">Block 4</div>
            </div>
            <div class="col-sm-4">
                <div class="block bg-white">Block 5</div>
            </div>
            <div class="col-sm-4">
                <div class="block bg-white">Block 6</div>
            </div>
        </div>

        <!-- Row 3 -->
        <div class="row">
            <div class="col-sm-4">
                <div class="block bg-white">Block 7</div>
            </div>
            <div class="col-sm-4">
                <div class="block bg-white">Block 8</div>
            </div>
            <div class="col-sm-4">
                <div class="block bg-white">Block 9</div>
            </div>
        </div>
    </div>
@endsection
