@extends('layout.layout')
@section('judul', 'Dashboard Guru Bk')
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
                <a href="/guru-bk/dashboard" class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4 active">
                    <img src="{{ asset('img/icon_Home_White.svg')}}" alt=""><span>Dashboard</span>
                </a>
                <a href="/guru-bk/presensi" class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4" aria-current="true">
                    <img src="{{ asset('img/icon_Location.svg')}}" alt=""><span>Jurusan</span>
                </a>
            </div>
        </div>
    </nav>
@endsection
@section('isi')
    <div class="container mt-3">
        <div class="row">
            <div class="col-sm-4 mb-5">
                <div class="block bg-white">
                    <div class="fs-1 color-text fw-bold">{{ $totalHadir }}</div>
                    <span class="fs-3 text-nowrap">Hadir</span>
                </div>
            </div>
            <div class="col-sm-4 mb-5">
                <div class="block bg-white">
                    <div class="fs-1 color-text fw-bold">{{ $totalIzin }}</div>
                    <span class="fs-3 text-nowrap">Tidak Hadir</span>
                </div>
            </div>
            <div class="col-sm-4 mb-5">
                <div class="block bg-white">
                    <div class="fs-1 color-text fw-bold">{{ $totalAlpha }}</div>
                    <span class="fs-3 text-nowrap">Sakit / Izin</span>
                </div>
            </div>
        </div>
    </div>
@endsection
