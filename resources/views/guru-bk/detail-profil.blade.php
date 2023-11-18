@extends('group.layout')
@section('judul', 'Detail Profil')
<style>
    .block {
        padding: 100px;
        text-align: center;
        border-radius: 20px
    }

    .color-text {
        color: #F9812A;
    }
</style>
@section('isi')
    <img class="" src="{{ asset('img/group_guru.png') }}" width="100%" height="250px" alt="" style="">
    <div class="container">
        <div class="d-flex justify-content-center">
            <img src="{{ asset('guru/' . $guru->foto_guru) }}" width="200px" height="200px" alt="Profile" class="mt-4 mb-2"
                style="border-radius: 100px;" alt="Guru" />
        </div>
        <div class="card mt-3  bg-white">
            <div class="card-body">
                <div class="container">

                    <div class="row">
                        <div class="col-sm">
                            Nama Guru
                        </div>
                        <div class="col-sm">
                            Username
                        </div>
                        <div class="col-sm">
                            Status Guru
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            {{ $guru->nama_guru }}
                        </div>
                        <div class="col-sm">
                            {{ $guru->username }}
                        </div>
                        <div class="col-sm">
                            Guru BK
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="mt-3 mb-5">
            <button id="kembali" class="btn text-decoration-underline text-light fw-bold rounded-3"
                style="background-color: #14C345; width: 150px;">KEMBALI</button>
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
