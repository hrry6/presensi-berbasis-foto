@extends('group.layout')
@section('judul', 'Edit Presensi')
@section('isi')
    <div class="pt-2">
        <h1 class="fw-bold mt-3 text-center">Edit Presensi</h1>
        <div class="container mt-3">
            <div class="row">
                <div class="col-lg-4 bg-white mb-3 mx-5" style="border-radius: 10%">
                    <img src="{{ asset('img/presensi.png') }}" alt="logo" class="img-fluid">
                </div>
                <div class="col-md-4 bg-white mb-3 mx-2 p-5" style="border-radius: 10px">
                    <form action="update" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Status Kehadiran</label>
                            <div>
                                @foreach ($statusKehadiran as $option)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" style="cursor: pointer" type="radio"
                                            name="status_kehadiran" id="{{ $option }}" value="{{ $option }}"
                                            {{ $presensi->status_kehadiran === $option ? 'checked' : '' }}>
                                        <label class="form-check-label" for="{{ $option }}">
                                            {{ $option }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan Lebih Lanjut</label>
                            <input type="text" class="form-control" name="keterangan"
                                value="{{ $presensi->keterangan }}">
                        </div>
                        <div class="form-group">
                            <label>Upload Bukti Izin/Sakit</label>
                            <input type="file" class="form-control" name="foto_bukti"
                                value="{{ $presensi->foto_bukti }}" />
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="id_presensi" value="{{ $presensi->id_presensi }}" />
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="id_siswa" value="{{ $presensi->id_siswa }}" />
                        </div>
                        <div class="mt-3">
                            <button id="kembali"
                                class="btn text-decoration-underline text-light fw-bold rounded-3"
                                style="background-color: #14C345">KEMBALI</button>
                            <button type="submit" class="btn text-decoration-underline text-light fw-bold"
                                style="background-color: #F9812A">SUBMIT</button>
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