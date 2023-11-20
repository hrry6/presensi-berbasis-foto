@extends('group.layout')
@section('judul', 'Detail Kelas')
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
    <br>
    <div class="container">
        <h1 class="mt-4 text-center">Detail Kelas</h1>
        <div class="card mt-3  bg-white">
            <div class="card-body">
                <div class="container">

                    <div class="row">
                        <div class="col-sm">
                            Tingkatan
                        </div>
                        <div class="col-sm">
                            Jurusan
                        </div>
                        <div class="col-sm">
                            Nama Kelas
                        </div>
                        <div class="col-sm">
                            Status Kelas
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            {{ $kelas->tingkatan }}
                        </div>
                        <div class="col-sm">
                            {{ $kelas->nama_jurusan }}
                        </div>
                        <div class="col-sm">
                            {{ $kelas->nama_kelas }}
                        </div>
                        <div class="col-sm">
                            {{ $kelas->status_kelas }}
                        </div>
                    </div>
                    
                    <br>

                    <div class="row d-flex justify-content-center w-full text-center">
                        <div class="col-sm">
                            Wali Kelas
                        </div>
                    </div>
                    
                    <div class="row d-flex justify-content-center w-full text-center">
                        <div class="col-sm">
                            @if (isset($kelas->nama_guru))                                
                                {{ $kelas->nama_guru }}
                            @else
                                Belum Ada
                            @endif
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-sm">
                            Ketua Kelas
                        </div>
                        <div class="col-sm">
                            Wakil Ketua
                        </div>
                        <div class="col-sm">
                            Sekretaris
                        </div>
                        <div class="col-sm">
                            Bendahara
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            @if (isset($ketua[0]))                                
                                @foreach ($ketua as $k)
                                    {{ $k->nama_siswa }}
                                    <br>
                                @endforeach    
                            @else
                                Belum Ada
                            @endif
                        </div>
                        <div class="col-sm">
                            @if (isset($wakil[0]))                                
                                @foreach ($wakil as $w)
                                    {{ $w->nama_siswa }}
                                    <br>
                                @endforeach    
                            @else
                                Belum Ada
                            @endif
                        </div>
                        <div class="col-sm">
                            @if (isset($sekretaris[0]))                                
                                @foreach ($sekretaris as $s)
                                    {{ $s->nama_siswa }}
                                    <br>
                                @endforeach    
                            @else
                                Belum Ada
                            @endif
                        </div>
                        <div class="col-sm">
                            @if (isset($bendahara[0]))                                
                                @foreach ($bendahara as $b)
                                    {{ $b->nama_siswa }}
                                    <br>
                                @endforeach    
                            @else
                                Belum Ada
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br>
        <h3>Daftar Siswa</h3>
        <br>

        <table class="table table-bordered DataTable">
            <thead class="thead table-dark">
                <tr class="">
                    <th scope="col">No</th>
                    <th scope="col">Foto</th>
                    <th scope="col">NIS</th>
                    <th scope="col">Nama Lengkap</th>
                    <th scope="col">Jenkel</th>
                    <th scope="col">Status Jabatan</th>
                    <th scope="col">Status Siswa</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($siswa as $i)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>
                            @if ($i->foto_siswa)
                                <img src="{{ url('siswa') . '/' . $i->foto_siswa }} "
                                    style="max-width: 100px; height: auto;" alt="Siswa" />
                            @endif
                        </td>
                        <td>{{ $i->nis }}</td>
                        <td>{{ $i->nama_siswa }}</td>
                        <td>{{ $i->jenis_kelamin }}</td>
                        <td>{{ $i->status_jabatan }}</td>
                        <td>{{ $i->status_siswa }}
                        </td>
                        <td class="d-flex justify-content-around align-items-center">
                            <a href="{{ $i->id_pengurus != null ? '/tata-usaha/detail-pengurus-kelas/'.$i->id_pengurus : '/tata-usaha/detail-siswa/'.$i->id_siswa }}">
                                <img src="{{ asset('img/icon_Vector.svg') }}" alt="">
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-3 mb-5">
            <button id="kembali" class="btn text-decoration-underline text-light fw-bold rounded-3"
                style="background-color: #14C345; width: 150px;">KEMBALI</button>
            <a href="{{ url('tata-usaha/edit-kelas/'.$kelas->id_kelas) }}" class="btn text-decoration-underline text-light fw-bold rounded-3"
                style="background-color: #F9812A; width: 200px;">EDIT KELAS</a>
            <button class="btnHapus btn btn-danger text-decoration-underline text-light fw-bold rounded-3"
                style="width: 150px;"  idHapus="{{ $kelas->id_kelas }}">HAPUS KELAS</button>
            <a href="/tata-usaha/tambah-pengurus-kelas?kelas={{ $kelas->id_kelas }}" class="btn btn-primary text-decoration-underline text-light fw-bold rounded-3"
                style="width: 200px;">TAMBAH PENGURUS</a>
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
                        url: '/tata-usaha/hapus-kelas',
                        data: {
                            id_kelas: idHapus,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            if (data.success) {
                                swal.fire('Berhasil di hapus!', '', 'success').then(function() {
                                    //Refresh Halaman
                                    window.location.href = "http://localhost:8000/tata-usaha/kelas";
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