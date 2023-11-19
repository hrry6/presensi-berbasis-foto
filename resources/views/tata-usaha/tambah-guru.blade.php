@extends('group.layout')
@section('judul', 'Tambah Guru')
@section('isi')
    <div class="pt-2">
        <h1 class="fw-bold mt-3 text-center">Tambah Guru</h1>
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
                            <input type="text" class="form-control @error('nama_guru') is-invalid @enderror" value="{{ old('nama_guru')}}" name="nama_guru">
                            @error('nama_guru') 
                                <div class="invalid-feedback">
                                    {{$message}}    
                                </div> 
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror">
                                <option value="" selected disabled>Pilih Status</option>
                                <option value="Guru BK" {{ old('status', request('status')) == 'Guru BK' ? 'selected' : '' }}>Guru BK</option>
                                <option value="Guru Piket" {{ old('status', request('status')) == 'Guru Piket' ? 'selected' : '' }}>Guru Piket</option>
                                @foreach ($kelas as $i)
                                    @if ($i->id_wali_kelas == null)
                                        <option value="{{ $i->id_kelas }}" {{ old('status', request('status')) == $i->id_kelas ? 'selected' : '' }}>Wali Kelas
                                            {{ $i->tingkatan . ' ' . $i->nama_jurusan . ' ' . $i->nama_kelas }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('status') 
                                <div class="invalid-feedback">
                                    {{$message}}    
                                </div> 
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" value="{{ old('username')}}" name="username">
                            @error('username') 
                                <div class="invalid-feedback">
                                    {{$message}}    
                                </div> 
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                            @error('password') 
                                <div class="invalid-feedback">
                                    {{$message}}    
                                </div> 
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Foto Profil Guru</label>
                            <input type="file" class="form-control @error('foto_guru') is-invalid @enderror" name="foto_guru" />
                            @error('foto_guru') 
                                <div class="invalid-feedback">
                                    {{$message}}    
                                </div> 
                            @enderror
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