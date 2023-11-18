@extends('layout.layout')
@section('judul', 'Presensi')
@section('sidenav')
    <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
        <div class="position-sticky">
            <div class="list-group list-group-flush mx-3 mt-4">
                <a href="/guru-bk/dashboard" class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4">
                    <img src="{{ asset('img/icon_Home.svg')}}" alt=""><span>Dashboard</span>
                </a>
                <a href="/guru-bk/presensi" class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4 active" aria-current="true">
                    <img src="{{ asset('img/icon_Location_White.svg')}}" alt=""><span>Presensi</span>
                </a>
            </div>
        </div>
    </nav>
@endsection
@section('isi')
<div class="mt-4 ml-4 pt-3 container-md bg-white">
    <form class="flex gap-3 flex-col w-auto mb-3" action="" method="get" id="form" >
        <div class="flex justify-content-between">
            <div class="flex">
                <input type="text" class="form-control" style="width:200px !important" name="keyword" value="{{ old('keyword', request('keyword')) }}" placeholder="Search Presensi....">
                <div class="input-group-append">
                    <button class="input-group-text bg-primary" > 
                        <img src="/img/icon_Search.svg" alt="">
                    </button>
                </div>
            </div>
            <button class="btn btn-success" id="downloadPDF">Download PDF</button>
        </div>
        <div class="flex gap-3">
            <input type="date" class="form-control filter" id="tanggal" value="{{ old('filter_tanggal', request('filter_tanggal'))}}" name="filter_tanggal" placeholder="Pilih Tanggal">
            <select class="form-select filter" name="filter_tingkatan" value="">
                <option value="" {{ old('filter_tingkatan', request('filter_tingkatan'))==""?"selected" : "" }}>Pilih Tingkatan</option>
                <option value="X" {{ old('filter_tingkatan', request('filter_tingkatan'))=="X"?"selected" : "" }}>X</option>
                <option value="XI" {{ old('filter_tingkatan', request('filter_tingkatan'))=="XI"?"selected" : "" }}>XI</option>
                <option value="XII" {{ old('filter_tingkatan', request('filter_tingkatan'))=="XII"?"selected" : "" }}>XII</option>
            </select>
            <select class="form-select filter" name="filter_jurusan" value="">
                <option value="" {{ old('filter_jurusan', request('filter_jurusan'))==""?"selected" : "" }}>Pilih Jurusan</option>
                @foreach ($jurusan as $j)
                <option value="{{ $j->id_jurusan}}" {{ old('filter_jurusan', request('filter_jurusan'))=="$j->id_jurusan"?"selected" : "" }}>{{ $j->nama_jurusan}}</option>
                @endforeach
            </select>
            <select class="form-select filter" name="filter_kehadiran" value="">
                <option value="" {{ old('filter_kehadiran', request('filter_kehadiran'))==""?"selected" : "" }}>Pilih Status Kehadiran</option>
                <option value="hadir" {{ old('filter_kehadiran', request('filter_kehadiran'))=="hadir"?"selected" : "" }}>Hadir</option>
                <option value="alpha" {{ old('filter_kehadiran', request('filter_kehadiran'))=="alpha"?"selected" : "" }}>Alpha</option>
                <option value="izin" {{ old('filter_kehadiran', request('filter_kehadiran'))=="izin"?"selected" : "" }}>Izin</option>
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
            </tr>
        </thead>
        <tbody>
            @foreach ($presensi as $p)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $p->nis }}</td>
                    <td>{{ $p->nama_siswa }}</td>
                    <td>{{ $p->tanggal }}</td>
                    <td>{{ $p->tingkatan." ".$p->nama_jurusan." ".$p->nama_kelas}}</td>
                    <td>{{ $p->status_kehadiran }}</td>
                    <td>
                        <img src="{{ url('presensi_bukti') . '/' . $p->foto_bukti }} "
                            style="max-width: 100px; height: auto;" alt="Bukti" alt="Bukti" />
                        
                    </td>
                    <td>{{ $p->keterangan }}</td>
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
        $('#downloadPDF').on('click', function(e){    
            $("#form").attr('action', '/guru-bk/presensi-pdf').submit();
        })
    </script>
@endsection