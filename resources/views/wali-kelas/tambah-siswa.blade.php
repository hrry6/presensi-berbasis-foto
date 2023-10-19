@extends('Layout.layout')
@section('judul', 'Dashboard Wali Kelas')
@section('isi')
    <h1 class="fw-bold mt-3">Tambah Akun Siswa</h1>
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-4 bg-primary mb-3 mx-2" style="border-radius: 10%">
                <img src="{{ asset('img/siswa.png') }}" alt="logo" class="img-fluid">
            </div>
            <div class="col bg-info mb-3 mx-2">
                Column
            </div>
        </div>
    </div>
@endsection
