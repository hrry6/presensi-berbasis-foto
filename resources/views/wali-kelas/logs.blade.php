@extends('layout.layout')
@section('judul', 'Logs')
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
                    class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4">
                    <img src="{{ asset('img/icon_Location.svg') }}" alt=""><span>Presensi</span>
                </a>
                <a href="{{ url('wali-kelas/logs') }}"
                    class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4 active">
                    <img src="{{ asset('img/icon_Book_White.svg') }}" alt=""><span>Logs</span>
                </a>
            </div>
        </div>
    </nav>
@endsection
@section('isi')

    <h1 class="fs-1 fw-bold text-center" style="margin-bottom: 2px">Logs</h1>
    <div class="mt-4 ml-4 pt-3 container-md bg-white">
        <div class="d-flex width-full justify-content-between mb-3">
            <form action="">
                <input type="text" placeholder="Search Logs">
                <button class="position-relative">Search</button>
            </form>
        </div>
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
                </tr>
            </thead>
            <tbody>
                @php
                    $counter = 0;
                @endphp

                @for ($i = 0; $i < count($logs); $i++)
                    @if ($logs[$i]->tabel !== 'guru' && $logs[$i]->aktor !== 'Tata Usaha')
                        <tr>
                            <td>{{ $counter++ }}</td>
                            <td>{{ $logs[$i]->tabel }}</td>
                            <td>{{ $logs[$i]->aktor }}</td>
                            <td>{{ $logs[$i]->tanggal }}</td>
                            <td>{{ $logs[$i]->jam }}</td>
                            <th>{{ $logs[$i]->aksi }}</th>
                            <th>{{ $logs[$i]->record }}</th>
                        </tr>
                    @endif
                @endfor

            </tbody>
        </table>

    </div>

@endsection
