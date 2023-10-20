@extends('group.layout')
@section('judul', 'Edit Wali Kelas')
@section('isi')
    <div class="pt-2">
        <h1 class="fw-bold mt-3 text-center">Edit Akun Siswa</h1>
        <div class="container mt-3">
            <div class="row">
                <div class="col-lg-4 bg-white mb-3 mx-5" style="border-radius: 10%">
                    <img src="{{ asset('img/siswa.png') }}" alt="logo" class="img-fluid">
                </div>
                <div class="col-md-4 bg-white mb-3 mx-2 p-5" style="border-radius: 10px">
                    <form action="/tata-usaha/edit-siswa/update" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="nis">NIS</label>
                            <input type="number" class="form-control" name="nis" value="{{ $siswa->nis }}">
                        </div>
                        <div class="form-group">
                            <label for="nama_siswa">Nama Siswa</label>
                            <input type="text" class="form-control" name="nama_siswa" value="{{ $siswa->nama_siswa }}">
                        </div>
                        <div class="form-group">
                            <label>Kelas</label>
                            <select name="id_kelas" class="form-control">
                                @foreach ($kelas as $data)
                                    <option value="{{ $data->id_kelas }}">{{ $data->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-control">
                                <option value="Laki-Laki" {{ $siswa->jenis_kelamin === 'Laki-Laki' ? 'selected' : '' }}>
                                    Laki-Laki</option>
                                <option value="Perempuan" {{ $siswa->jenis_kelamin === 'Perempuan' ? 'selected' : '' }}>
                                    Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nomer_hp">Nomer Hp</label>
                            <input type="number" class="form-control" name="nomer_hp" value="{{ $siswa->nomer_hp }}">
                        </div>
                        <div class="form-group">
                            <label>Foto Profil Siswa</label>
                            <input type="file" class="form-control" name="foto_siswa" />
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="id_siswa" value="{{ $siswa->id_siswa }}" />
                        </div>
                        <div class="mt-3">
                            <a href="#" onclick="window.history.back();" class="btn btn-success">KEMBALI</a>
                            <button type="submit" class="btn btn-primary">SUBMIT</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
