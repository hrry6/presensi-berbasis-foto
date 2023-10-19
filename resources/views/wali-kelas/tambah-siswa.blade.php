@extends('group.layout')
@section('judul', 'Dashboard Wali Kelas')
@section('isi')
    <div class="pt-2">
        <h1 class="fw-bold mt-3 text-center">Tambah Akun Siswa</h1>
        <div class="container mt-3">
            <div class="row">
                <div class="col-md-4 bg-white mb-3 mx-2" style="border-radius: 10%">
                    <img src="{{ asset('img/siswa.png') }}" alt="logo" class="img-fluid">
                </div>
                <div class="col-md-4 bg-warning mb-3 mx-2 w-50" style="border-radius: 10px">
                    <form>
                        <div class="form-group w-50">
                            <label for="nis">NIS</label>
                            <input type="text" class="form-control" name="nis">
                        </div>
                        <div class="form-group">
                            <label for="nama_siswa">Nama Siswa</label>
                            <input type="text" class="form-control" name="nis">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
