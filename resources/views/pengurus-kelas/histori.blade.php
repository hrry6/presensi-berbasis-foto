@extends('layout.layout')
@section('judul', 'Dashboard Siswa')
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
    <nav id="sidebarMenu" class="collapse d-lg-block sidebar bg-white">
        <div class="position-sticky">
            <div class="list-group list-group-flush mx-3 mt-4">
                <a href="/pengurus-kelas/dashboard"
                    class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4" aria-current="true">
                    <img src="{{ asset('img/icon_Home.svg') }}" alt=""><span>Dashboard</span>
                </a>
                <a href="/pengurus-kelas/presensi" class="list-group-item list-group-item-action py-2 ripple">
                    <i class="fas fa-chart-area fa-fw me-3"></i><span>Presensi</span>
                </a>
                <a href="/pengurus-kelas/kelas" class="list-group-item list-group-item-action py-2 ripple">
                    <i class="fas fa-chart-area fa-fw me-3"></i><span>Kelas</span>
                </a>
                <a href="/pengurus-kelas/histori" class="list-group-item list-group-item-action py-2 ripple active">
                    <i class="fas fa-chart-area fa-fw me-3"></i><span>Histori</span>
                </a>
            </div>
        </div>
    </nav>
@endsection
@section('isi')
    <div class="mt-4 ml-4 pt-3 container-md bg-white">
        <form action="" method="get">
            <div class="flex gap-3 w-50 mt-3">
                <select class="form-select" name="bulan" id="bulan" onchange="this.form.submit()">
                    <option value="" {{ $selectedMonth === null ? 'selected' : '' }}>Semua Bulan</option>
                    @foreach ($bulanList as $index => $bulan)
                        <option value="{{ $index }}" {{ $selectedMonth == $index ? 'selected' : '' }}>
                            {{ $bulan }}
                        </option>
                    @endforeach
                </select>

                <select class="form-select" name="minggu" id="minggu" onchange="this.form.submit()">
                    <option value="" {{ $selectedWeek === null ? 'selected' : '' }}>Semua Minggu</option>
                    @for ($i = 1; $i <= 4; $i++)
                        <option value="{{ $i }}" {{ $selectedWeek == $i ? 'selected' : '' }}>
                            Minggu ke-{{ $i }}
                        </option>
                    @endfor
                </select>
            </div>
        </form>
        <table class="table table-bordered DataTable">
            <thead class="thead table-dark">
                <tr class="">
                    <th scope="col">No</th>
                    <th scope="col">NIS</th>
                    <th scope="col">Nama Siswa</th>
                    <th scope="col">Jenis Kelamin</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Kehadiran</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($data as $i)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $i->nis }}</td>
                        <td>{{ $i->nama_siswa }}</td>
                        <td>{{ $i->jenis_kelamin }}</td>
                        <td>{{ $i->tanggal }}</td>
                        <td>{{ $i->status_kehadiran }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
