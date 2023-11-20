@extends('group.layout')
@section('judul', 'Detail Guru')
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
        <h1 class="mt-4 text-center">Detail Guru</h1>
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
                            @if(isset($guruBk))
                                Guru BK
                                @endif
                            @if (isset($guruPiket))
                                Guru Piket
                            @endif
                            @if (isset($kelas))
                                Wali Kelas                                                                
                            @endif
                        </div>
                    </div>

                    @if (isset($kelas[0]))
                        <br>
                        <div class="" style="width:400 !important;">
                            <div class="row d-flex">
                                <div class="col-sm">
                                    Membina Kelas
                                </div>
                            </div>
                            <div class="row d-flex flex-column">
                                @foreach ($kelas as $k)                                
                                <div class="col-sm">
                                    {{ $k->tingkatan }}
                                    {{ $k->nama_jurusan }}
                                    {{ $k->nama_kelas }}
                                    (
                                        {{ $k->status_kelas }}
                                    )
                                </div>
                                <br>
                                @endforeach
                            </div>
                        </div>
                    @endif

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
            $('.container').on('click', '.btnHapus', function(a) {
            a.preventDefault();
            let idHapus = $(this).closest('.btnHapus').attr('idHapus');
            swal.fire({
                title: "Apakah anda yakin?",
                text: "Anda tidak dapat mengembalikkan nya lagi!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Ya, Hapus!",
                cancelButtonColor: "#d33",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'DELETE',
                        url: '/tata-usaha/hapus-guru',
                        data: {
                            id_guru: idHapus,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            if (data.success) {
                                swal.fire('Berhasil di hapus!', '', 'success').then(function() {
                                    //Refresh Halaman
                                    window.location.href = "http://localhost:8000/tata-usaha/akun-guru";
                                });
                            }
                        }
                    });
                }
                });
            });
            $('#kembali').on('click', function(){
                window.history.back();
            });
        });
    </script>
@endsection
