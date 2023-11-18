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
            <a href="{{ url('tata-usaha/akun-pengurus-kelas') }}" class="btn text-decoration-underline text-light fw-bold rounded-3"
                style="background-color: #14C345; width: 150px;">KEMBALI</a>
            <a href="{{ url('tata-usaha/edit-pengurus-kelas/'.$pengurus->id_pengurus) }}" class="btn text-decoration-underline text-light fw-bold rounded-3"
                style="background-color: #F9812A; width: 200px;">EDIT DATA PENGURUS</a>
            <a href="{{ url('tata-usaha/edit-siswa/'.$pengurus->id_siswa) }}" class="btn text-decoration-underline text-light fw-bold rounded-3"
                style="background-color: #F9812A; width: 200px;">EDIT DATA SISWA</a>
        </div>
    </div>
@endsection
