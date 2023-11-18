@extends('group.layout')
@section('judul', 'Edit Guru')
@section('isi')
    <div class="pt-2">
        <h1 class="fw-bold mt-3 text-center">Edit Guru</h1>
        <div class="container mt-3">
            <div class="row">
                <div class="col-lg-4 bg-white mb-3 mx-5" style="border-radius: 10%">
                    <img src="{{ asset('img/guru-form.png') }}" alt="logo" class="img-fluid">
                </div>
                <div class="col-md-4 bg-white mb-3 mx-2 p-5" style="border-radius: 10px">
                    <form action="update" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="nama_guru">Nama Guru</label>
                            <input type="text" class="form-control" name="nama_guru" value="{{ $guru->nama_guru }}">
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="" disabled>Pilih Status</option>
                                <option value="Guru BK" {{ $guruBk === null ? '' : 'selected' }}>Guru BK</option>
                                <option value="Guru Piket" {{ $guruPiket === null ? '' : 'selected' }}>Guru Piket</option>
                                @foreach ($kelas as $i)
                                    <option value="{{ $i->id_kelas }}"
                                        {{ $i->id_wali_kelas == $guru->id_guru ? 'selected' : '' }}>
                                        {{ $i->tingkatan . ' ' . $i->nama_jurusan . ' ' . $i->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" value="{{ $guru->username }}">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="text" class="form-control" name="password">
                        </div>
                        <div class="form-group">
                            <label>Foto Guru</label>
                            <input type="file" class="form-control" name="foto_guru" />
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="id_guru" value="{{ $guru->id_guru }}" />
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