@extends('group.layout')
@section('judul', 'Tambah Akun Guru')
@section('isi')
    <div class="pt-2">
        <h1 class="fw-bold mt-3 text-center">Tambah Akun Guru</h1>
        <div class="container mt-3">
            <div class="row">
                <div class="col-lg-4 bg-white mb-3 mx-5" style="border-radius: 10%">
                    <img src="{{ asset('img/guru-form.png') }}" alt="logo" class="img-fluid">
                </div>
                <div class="col-md-4 bg-white mb-3 mx-2 p-5" style="border-radius: 10px">
                    <form action="simpan-guru" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="nama_guru">Nama Guru</label>
                            <input type="text" class="form-control" name="nama_guru">
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="Guru BK">Guru BK</option>
                                <option value="Guru Piket">Guru Piket</option>
                                @foreach ($kelas as $i)
                                    @if ($i->id_wali_kelas == null)
                                        <option value="{{ $i->id_kelas }}">Wali Kelas
                                            {{ $i->tingkatan . ' ' . $i->nama_jurusan . ' ' . $i->nama_kelas }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Foto Profil Guru</label>
                            <input type="file" class="form-control" name="foto_guru" />
                        </div>
                        <div class="mt-3">
                            <a href="{{ url('tata-usaha/akun-guru') }}"
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
