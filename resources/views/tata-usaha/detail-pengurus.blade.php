@extends('group.layout')
@section('judul', 'Detail Pengurus')
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
        <h1 class="mt-4 text-center">Detail Pengurus Kelas</h1>
        <div class="d-flex justify-content-center">
            <img src="{{ asset('siswa/' . $pengurus->foto_siswa) }}" width="200px" height="200px" alt="Profile" class="mt-4 mb-2"
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
                            Nama Pengurus
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
                            {{ $pengurus->nis }}
                        </div>
                        <div class="col-sm">
                            {{ $pengurus->nama_siswa }}
                        </div>
                        <div class="col-sm">
                            {{ $pengurus->nomer_hp }}
                        </div>
                        <div class="col-sm">
                            {{ $pengurus->jenis_kelamin }}
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
                            {{ $pengurus->tingkatan }}
                        </div>
                        <div class="col-sm">
                            {{ $pengurus->nama_kelas }}
                        </div>
                        <div class="col-sm">
                            {{ $pengurus->nama_jurusan }}
                        </div>
                        <div class="col-sm">
                            {{ $pengurus->status_siswa }}
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
                            {{ $pengurus->jabatan }} - {{ $pengurus->status_jabatan }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="mt-3 mb-5">
            <button id="kembali" class="btn text-decoration-underline text-light fw-bold rounded-3"
                style="background-color: #14C345; width: 150px;">KEMBALI</button>
            <a href="{{ url('tata-usaha/edit-pengurus-kelas/'.$pengurus->id_pengurus) }}" class="btn text-decoration-underline text-light fw-bold rounded-3"
                style="background-color: #F9812A; width: 200px;">EDIT DATA PENGURUS</a>
            <a href="{{ url('tata-usaha/edit-siswa/'.$pengurus->id_siswa) }}" class="btn text-decoration-underline text-light fw-bold rounded-3"
                style="background-color: #F9812A; width: 200px;">EDIT DATA SISWA</a>
            <button class="hapusPengurus btn btn-danger text-decoration-underline text-light fw-bold rounded-3"
                style="width: 250px;"  idPengurus="{{ $pengurus->id_pengurus }}">HAPUS STATUS PENGURUS</button>
            <button class="hapusSiswa btn btn-danger text-decoration-underline text-light fw-bold rounded-3"
                style="width: 150px;"  idSiswa="{{ $pengurus->id_siswa }}">HAPUS SISWA</button>
        </div>
    </div>
@endsection
@section('footer')
    <script type="module">
        $(document).ready(function(){
            $('.container').on('click', '.hapusSiswa', function(a) {
            a.preventDefault();
            let idSiswa = $(this).closest('.hapusSiswa').attr('idSiswa');
            swal.fire({
                title: "Apakah anda yakin?",
                text: "Anda tidak dapat mengembalikkan nya lagi!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Ya, Hapus!",
                cancelButtonColor: "#d33",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'DELETE',
                        url: '/tata-usaha/hapus-siswa',
                        data: {
                            id_siswa: idSiswa,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            if (data.success) {
                                swal.fire('Berhasil di hapus!', '', 'success').then(function() {
                                    //Refresh Halaman
                                    window.location.href = "http://localhost:8000/tata-usaha/akun-siswa";
                                });
                            }
                        }
                    });
                }
                });
            });
            $('.container').on('click', '.hapusPengurus', function(a) {
            a.preventDefault();
            let idPengurus = $(this).closest('.hapusPengurus').attr('idPengurus');
            swal.fire({
                title: "Apakah anda yakin?",
                text: "Anda tidak dapat mengembalikkan nya lagi!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Ya, Hapus!",
                cancelButtonColor: "#d33",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'DELETE',
                        url: '/tata-usaha/hapus-pengurus-kelas',
                        data: {
                            id_pengurus: idPengurus,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            if (data.success) {
                                swal.fire('Berhasil di hapus!', '', 'success').then(function() {
                                    //Refresh Halaman
                                    window.location.href = "http://localhost:8000/tata-usaha/akun-pengurus-kelas";
                                });
                            }
                        }
                    });
                }
                });
            });
            $('#kembali').on('click', function(){
                window.history.back();
            });
        });
    </script>
@endsection