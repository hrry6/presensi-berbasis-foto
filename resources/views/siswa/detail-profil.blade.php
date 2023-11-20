@extends('group.layout')
@section('judul', 'Detail Siswa')
<style>
    .block {
        padding: 100px;
        text-align: center;
        border-radius: 20px
    }

    .color-text {
        color: #F9812A;
    }
    /* .gambar{
        height: auto;
        width: auto;        
    } */
</style>
@section('isi')
    <img src="{{ asset('img/group_siswa.png') }}" width="100%" height="200px" alt="" style="object-fit: fill;">
    <div class="container">
        <h1 class="mt-4 text-center">Detail Siswa</h1>
        <div class="d-flex justify-content-center">
            <img src="{{ asset('siswa/' . $siswa->foto_siswa) }}" width="200px" height="200px" alt="Profile" class="mt-4 mb-2"
                style="border-radius: 100px;" alt="Siswa" />
        </div>
        <div class="card mt-3  bg-white">
            <div class="card-body">
                <div class="container">

                    <div class="row">
                        <div class="col-sm">
                            NIS
                        </div>
                        <div class="col-sm">
                            Nama Siswa
                        </div>
                        <div class="col-sm">
                            Nomer Hp
                        </div>
                        <div class="col-sm">
                            Jenis Kelamin
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            {{ $siswa->nis }}
                        </div>
                        <div class="col-sm">
                            {{ $siswa->nama_siswa }}
                        </div>
                        <div class="col-sm">
                            {{ $siswa->nomer_hp }}
                        </div>
                        <div class="col-sm">
                            {{ $siswa->jenis_kelamin }}
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-sm">
                            Tingkat
                        </div>
                        <div class="col-sm">
                            Kelas
                        </div>
                        <div class="col-sm">
                            Jurusan
                        </div>
                        <div class="col-sm-3">
                            Status Siswa
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            {{ $siswa->tingkatan }}
                        </div>
                        <div class="col-sm">
                            {{ $siswa->nama_kelas }}
                        </div>
                        <div class="col-sm">
                            {{ $siswa->nama_jurusan }}
                        </div>
                        <div class="col-sm-3">
                            {{ $siswa->status_siswa }}
                        </div>
                    </div>

                    <br>

                    <div class="row d-flex justify-content-center w-full text-center">
                        <div class="col-sm-6">
                            Status Jabatan
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center w-full text-center">
                        <div class="col-sm-6">
                            @if ($pengurus)
                                {{ $pengurus->jabatan }} - {{ $siswa->status_jabatan }}
                            @else
                                {{ $siswa->status_jabatan }}
                            @endif
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
                        url: '/tata-usaha/hapus-siswa',
                        data: {
                            id_siswa: idHapus,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            if (data.success) {
                                swal.fire('Berhasil di hapus!', '', 'success').then(function() {
                                    //Refresh Halaman
                                    window.location.href = "http://localhost:8000/tata-usaha/akun-siswa";
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
