@extends('group.layout')
@section('judul', 'Detail Siswa')
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
            <img src="{{ asset('siswa/' . $siswa->foto_siswa) }}" width="200px" height="200px" alt="Profile" class="mt-4 mb-2"
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
                            {{ $siswa->nis }}
                        </div>
                        <div class="col-sm">
                            {{ $siswa->nama_siswa }}
                        </div>
                        <div class="col-sm">
                            {{ $siswa->nomer_hp }}
                        </div>
                        <div class="col-sm">
                            {{ $siswa->jenis_kelamin }}
                        </div>
                    </div>

                    <div class="row mt-3">
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
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            {{ $siswa->tingkatan }}
                        </div>
                        <div class="col-sm">
                            {{ $siswa->nama_kelas }}
                        </div>
                        <div class="col-sm">
                            {{ $siswa->nama_jurusan }}
                        </div>
                        <div class="col-sm">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-sm-3">
                            Status Siswa
                        </div>
                        <div class="col-sm-6">
                            Status Jabatan
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            {{ $siswa->status_siswa }}
                        </div>
                        <div class="col-sm-6">
                            @if ($pengurus)
                                {{ $pengurus->jabatan }} - {{ $siswa->status_jabatan }}
                            @else
                                {{ $siswa->status_jabatan }}
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="mt-3 mb-5">
            <a href="{{ url('tata-usaha/akun-siswa') }}" class="btn text-decoration-underline text-light fw-bold rounded-3"
                style="background-color: #14C345; width: 150px;">KEMBALI</a>
                <a href="{{ url('tata-usaha/edit-siswa/'.$siswa->id_siswa) }}" class="btn text-decoration-underline text-light fw-bold rounded-3"
                style="background-color: #F9812A; width: 150px;">EDIT</a>
        </div>
    </div>
@endsection
