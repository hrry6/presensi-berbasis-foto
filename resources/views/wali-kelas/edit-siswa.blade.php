@extends('group.layout')
@section('judul', 'Edit Data Diri Siswa')
@section('isi')
    <div class="pt-2">
        <h1 class="fw-bold mt-3 text-center">Edit Data Diri Siswa</h1>
        <div class="container mt-3">
            <div class="row">
                <div class="col-lg-4 bg-white mb-3 mx-5" style="border-radius: 10%">
                    <img src="{{ asset('img/siswa.png') }}" alt="logo" class="img-fluid">
                </div>
                <div class="col-md-4 bg-white mb-3 mx-2 p-5" style="border-radius: 10px">
                    <form action="{{ url('wali-kelas/edit-siswa/simpan') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="nis">NIS</label>
                            <input type="number" class="form-control" name="nis" value="{{ $siswa->nis }}">
                        </div>

                        <div class="form-group">
                            @error('nama_siswa')
                                <div class="text-danger p-0 m-0">{{ $message }}</div>
                            @enderror
                            <label for="nama_siswa">Nama Siswa</label>
                            <input type="text" class="form-control @error('nama_siswa') is-invalid @enderror"
                                name="nama_siswa" value="{{ $siswa->nama_siswa }}">
                        </div>

                        <div class="form-group">
                            <label>Kelas</label>
                            @foreach ($kelas as $i)
                                @if ($siswa->id_kelas === $i->id_kelas)
                                    <input type="text" class="form-control"
                                        value="{{ $i->tingkatan . ' ' . $i->nama_jurusan . ' ' . $i->nama_kelas }}"
                                        readonly>
                                @endif
                            @endforeach
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
                            <label>Status Jabatan</label>
                            <select name="status_jabatan" class="form-control">
                                @foreach ($statusJabatan as $i)
                                    <option value="{{ $i }}"
                                        {{ $siswa->status_jabatan === $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nomer_hp">Nomer Hp</label>
                            <input type="number" class="form-control" name="nomer_hp" value="{{ $siswa->nomer_hp }}">
                        </div>
                        <div class="form-group">
                            @error('foto_siswa')
                                <div class="text-danger p-0 m-0">{{ $message }}</div>
                            @enderror
                            <label>Foto Profil Siswa</label>
                            <input type="file" class="form-control @error('foto_siswa') is-invalid @enderror"
                                name="foto_siswa" />
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="id_siswa" value="{{ $siswa->id_siswa }}" />
                        </div>
                        <div class="mt-3">
                            <a href="{{ url()->previous() }}"
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
