@extends('group.layout')
@section('judul', 'Tambah Kelas')
@section('isi')
    <div class="pt-2">
        <h1 class="fw-bold mt-3 text-center">Tambah Kelas</h1>
        <div class="container mt-3">
            <div class="row">
                <div class="col-lg-4 bg-white mb-3 mx-5" style="border-radius: 10%">
                    <img src="{{ asset('img/siswa.png') }}" alt="logo" class="img-fluid">
                </div>
                <div class="col-md-4 bg-white mb-3 mx-2 p-5" style="border-radius: 10px">
                    <form action="simpan-kelas" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Tingkatan</label>
                            <select name="tingkatan" class="form-control">
                                <option value="" selected disabled>
                                    Pilih Tingkatan
                                </option>
                                <option value="X">
                                    X
                                </option>
                                <option value="XI">
                                    XI
                                </option>
                                <option value="XII">
                                    XII
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Jurusan</label>
                            <select name="id_jurusan" class="form-control">
                                <option value="" selected disabled>
                                    Pilih Jurusan
                                </option>
                                @foreach ($jurusan as $j)
                                <option value="{{ $j->id_jurusan }}">
                                    {{ $j->nama_jurusan}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama_kelas">Nama Kelas</label>
                            <input type="text" class="form-control" name="nama_kelas">
                        </div>
                        <div class="form-group">
                            <label>Status Kelas</label>
                            <select name="status_kelas" class="form-control">
                            <option value="" selected disabled>
                                Pilih Status
                            </option>
                            <option value="aktif" selected>
                                Aktif
                            </option>
                            <option value="tidak_aktif">
                                Tidak Aktif
                            </option>
                        </select>
                        <div>
                        <div class="mt-3">
                            <a href="{{ url('tata-usaha/kelas') }}"
                                class="btn text-decoration-underline text-light fw-bold rounded-3"
                                style="background-color: #14C345">KEMBALI</a>
                            <button type="submit" class="btn text-decoration-underline text-light fw-bold"
                                style="background-color: #F9812A ">SUBMIT</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
