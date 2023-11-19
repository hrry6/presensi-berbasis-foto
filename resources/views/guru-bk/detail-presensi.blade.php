@extends('group.layout')
@section('judul', 'Detail Presensi')
<style>
    .block {
        padding: 100px;
        text-align: center;
        border-radius: 20px
    }

    .color-text {
        color: #F9812A;
    }
    /* .gambar{
        height: auto;
        width: auto;        
    } */
</style>
@section('isi')
    <img src="{{ asset('img/group_siswa.png') }}" width="100%" height="200px" alt="" style="object-fit: fill;">
    <div class="container">
        <div class="d-flex justify-content-center">
            <img src="{{ asset('siswa/' . $presensi->foto_siswa) }}" width="200px" height="200px" alt="Profile" class="mt-4 mb-2"
                style="border-radius: 100px;" alt="Siswa" />
        </div>
        <div class="card mt-3  bg-white">
            <div class="card-body">
                <div class="container">

                    <div class="row">
                        <div class="col-sm">
                            NIS
                        </div>
                        <div class="col-sm">
                            Nama Siswa
                        </div>
                        <div class="col-sm">
                            Nomer Hp
                        </div>
                        <div class="col-sm">
                            Jenis Kelamin
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            {{ $presensi->nis }}
                        </div>
                        <div class="col-sm">
                            {{ $presensi->nama_siswa }}
                        </div>
                        <div class="col-sm">
                            {{ $presensi->nomer_hp }}
                        </div>
                        <div class="col-sm">
                            {{ $presensi->jenis_kelamin }}
                        </div>
                    </div>
                    
                    <br>

                    <div class="row">
                        <div class="col-sm">
                            Tingkat
                        </div>
                        <div class="col-sm">
                            Kelas
                        </div>
                        <div class="col-sm">
                            Jurusan
                        </div>
                        <div class="col-sm">
                            Status Pengurus
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            {{ $presensi->tingkatan }}
                        </div>
                        <div class="col-sm">
                            {{ $presensi->nama_kelas }}
                        </div>
                        <div class="col-sm">
                            {{ $presensi->nama_jurusan }}
                        </div>
                        <div class="col-sm">
                            {{ $presensi->status_siswa }}
                        </div>
                    </div>

                    <br>
                    <div class="row d-flex justify-content-center w-full text-center">
                        <div class="col-sm">
                            Status Jabatan
                        </div>
                    </div>

                    <div class="row d-flex justify-content-center w-full text-center">
                        <div class="col-sm">
                            {{ $presensi->jabatan }} - {{ $presensi->status_jabatan }}
                        </div>
                    </div>

                    <br>
                    <div class="row">
                        <div class="col-sm">
                            Tanggal
                        </div>
                        <div class="col-sm">
                            Jam Masuk
                        </div>
                        <div class="col-sm">
                            Status Kehadiran
                        </div>
                        <div class="col-sm">
                            Keterangan
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            {{ $presensi->tanggal }}
                        </div>
                        <div class="col-sm">
                            {{ $presensi->jam_masuk }}
                        </div>
                        <div class="col-sm">
                            {{ $presensi->status_kehadiran }}
                        </div>
                        <div class="col-sm">
                            {{ $presensi->keterangan }}
                        </div>
                    </div>

                    <br>
                    <div class="row">
                        <div class="col-sm">
                            Bukti Kehadiran
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <img src="{{ url('presensi_bukti') . '/' . $presensi->foto_bukti }} "
                                style="max-width: 100px; height: auto;" alt="Bukti" alt="Gambar-Bukti" />
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="mt-3 mb-5">
            <button id="kembali" class="btn text-decoration-underline text-light fw-bold rounded-3"
                style="background-color: #14C345; width: 150px;">KEMBALI</button>
        </div>
    </div>
@endsection
@section('footer')
    <script type="module">
        $(document).ready(function(){
            $('#kembali').on('click', function(){
                window.history.back();
            });
        });
    </script>
@endsection