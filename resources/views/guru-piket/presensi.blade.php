@extends('layout.layout')
@section('judul', 'Kelola Presensi')
@section('sidenav')
    <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
        <div class="position-sticky">
            <div class="list-group list-group-flush mx-3 mt-4">
                <a href="/guru-piket/dashboard" class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4">
                    <img src="{{ asset('img/icon_Home.svg')}}" alt=""><span>Dashboard</span>
                </a>
                <a href="/guru-piket/akun-pengurus-kelas" class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4 ">
                    <img src="{{ asset('img/icon_Profile.svg')}}" alt=""><span>Pengurus Kelas</span>
                </a>
                <a href="/guru-piket/presensi" class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4 active" aria-current="true">
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
            <div class="flex gap-3">
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
            <select class="form-select filter" name="filter_kelas" value="">
                <option value="" {{ old('filter_jurusan', request('filter_kelas')) == '' ? 'selected' : '' }}>
                    Pilih Kelas</option>
                @foreach ($kelas as $k)
                    <option value="{{ $k->id_kelas }}"
                        {{ old('filter_kelas', request('filter_kelas')) == "$k->id_kelas" ? 'selected' : '' }}>
                        {{ $k->tingkatan." ".$k->nama_jurusan." ".$k->nama_kelas }}</option>
                @endforeach
            </select>
            <select class="form-select" id="filter_bulan" name="filter_bulan" value="">
                <option value="" {{ old('filter_bulan', request('filter_bulan')) == '' ? 'selected' : '' }}>
                    Pilih Bulan</option>
                    <option value="01"
                    {{ old('filter_bulan', request('filter_bulan')) == '01' ? 'selected' : '' }}>Januari</option>
                    <option value="02"
                    {{ old('filter_bulan', request('filter_bulan')) == '02' ? 'selected' : '' }}>Februari</option>                        
                    <option value="03"
                    {{ old('filter_bulan', request('filter_bulan')) == '03' ? 'selected' : '' }}>Maret</option>
                    <option value="04"
                    {{ old('filter_bulan', request('filter_bulan')) == '04' ? 'selected' : '' }}>April</option>
                    <option value="05"
                    {{ old('filter_bulan', request('filter_bulan')) == '05' ? 'selected' : '' }}>Mei</option>
                    <option value="06"
                    {{ old('filter_bulan', request('filter_bulan')) == '06' ? 'selected' : '' }}>Juni</option>                        
                    <option value="07"
                    {{ old('filter_bulan', request('filter_bulan')) == '07' ? 'selected' : '' }}>Juli</option>
                    <option value="08"
                    {{ old('filter_bulan', request('filter_bulan')) == '08' ? 'selected' : '' }}>Agustus</option>
                    <option value="09"
                    {{ old('filter_bulan', request('filter_bulan')) == '09' ? 'selected' : '' }}>September</option>
                    <option value="10"
                    {{ old('filter_bulan', request('filter_bulan')) == '10' ? 'selected' : '' }}>Oktober</option>                        
                    <option value="11"
                    {{ old('filter_bulan', request('filter_bulan')) == '11' ? 'selected' : '' }}>November</option>
                    <option value="12"
                    {{ old('filter_bulan', request('filter_bulan')) == '12' ? 'selected' : '' }}>Desember</option>                        
                </select>
            <input type="date" class="form-control" id="filter_tanggal" id="tanggal"
                value="{{ old('filter_tanggal', request('filter_tanggal')) }}" name="filter_tanggal"
                placeholder="Pilih Tanggal">
            <select class="form-select filter" name="filter_kehadiran" value="">
                <option value="" {{ old('filter_kehadiran', request('filter_kehadiran')) == '' ? 'selected' : '' }}>
                    Pilih Status Kehadiran</option>
                <option value="hadir"
                    {{ old('filter_kehadiran', request('filter_kehadiran')) == 'hadir' ? 'selected' : '' }}>Hadir</option>
                <option value="alpha"
                    {{ old('filter_kehadiran', request('filter_kehadiran')) == 'alpha' ? 'selected' : '' }}>Alpha</option>
                <option value="izin"
                    {{ old('filter_kehadiran', request('filter_kehadiran')) == 'izin' ? 'selected' : '' }}>Izin</option>
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
                    <td>{{ $p->tingkatan." ".$p->nama_jurusan." ".$p->nama_kelas}}</td>
                    <td>{{ $p->status_kehadiran }}</td>
                    <td>
                        <img src="{{ url('presensi_bukti') . '/' . $p->foto_bukti }} "
                            style="max-width: 100px; height: auto;" alt="Bukti" alt="Bukti" />
                    </td>
                    <td>{{ $p->keterangan }}</td>
                    <td class="flex gap-2">
                        {{-- <a href="/guru-piket/detail-presensi/{{ $p->id_presensi }}">
                            <img src="{{ asset('img/icon_Vector.svg') }}" alt="">
                        </a> --}}
                        <a href="/guru-piket/edit-presensi/{{ $p->id_presensi }}">
                            <img src="{{ asset('img/icon_Edit.svg')}}" alt="">
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

        $('#filter_bulan').change(function() {
            if ($(this).val() !== '') {
                $('#filter_tanggal').prop('disabled', true);
            } else {
                $('#filter_tanggal').prop('disabled', false);
            }
            $("#form").submit();
        });

        $('#filter_tanggal').change(function() {
            if ($(this).val() !== '') {
                $('#filter_bulan').prop('disabled', true);
            } else {
                $('#filter_bulan').prop('disabled', false);
            }
            $("#form").submit();
        });


        $('#downloadPDF').on('click', function(e) {
            $("#form").attr('action', '/tata-usaha/presensi-pdf').submit();
        })
    </script>
@endsection