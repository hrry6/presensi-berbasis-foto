@extends('group.layout')
@section('judul', 'Tambah Siswa')
@section('isi')
    <div class="pt-2">
        <h1 class="fw-bold mt-3 text-center">Tambah Siswa</h1>
        <div class="container mt-3">
            <div class="row">
                <div class="col-lg-4 bg-white mb-3 mx-5" style="border-radius: 10%">
                    <img src="{{ asset('img/siswa.png') }}" alt="logo" class="img-fluid">
                </div>
                <div class="col-md-4 bg-white mb-3 mx-2 p-5" style="border-radius: 10px">
                    <form action="simpan-siswa" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="nis">NIS</label>
                            <input type="number" class="form-control" name="nis">
                        </div>
                        <div class="form-group">
                            <label for="nama_siswa">Nama Siswa</label>
                            <input type="text" class="form-control" name="nama_siswa">
                        </div>
                        <div class="form-group">
                            <label>Kelas</label>
                            <select name="id_kelas" class="form-control">
                                <option value="" selected disabled>Pilih Kelas</option>
                                @foreach ($kelas as $i)
                                    <option value="{{ $i->id_kelas }}">
                                        {{ $i->tingkatan . ' ' . $i->nama_jurusan . ' ' . $i->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <div>
                                @foreach ($jenisKelamin as $option)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" style="cursor: pointer" type="radio"
                                            name="jenis_kelamin" id="{{ $option }}" value="{{ $option }}"
                                            {{ $siswa->jenis_kelamin === $option ? 'checked' : '' }}>
                                        <label class="form-check-label" for="{{ $option }}">
                                            {{ $option }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nomer_hp">Nomer Hp</label>
                            <input type="number" class="form-control" name="nomer_hp">
                        </div>
                        <div class="form-group">
                            <label for="angkatan">Angkatan</label>
                            <input type="number" class="form-control" name="angkatan">
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                        <div class="form-group">
                            <label>Foto Profil Siswa</label>
                            <input type="file" class="form-control" name="foto_siswa" />
                        </div>
                        <div class="mt-3">
                            <button id="kembali"
                                class="btn text-decoration-underline text-light fw-bold rounded-3"
                                style="background-color: #14C345">KEMBALI</button>
                            <button type="submit" class="btn text-decoration-underline text-light fw-bold"
                                style="background-color: #F9812A ">SUBMIT</button>
                        </div>
                    </form>
                </div>
            </div>
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