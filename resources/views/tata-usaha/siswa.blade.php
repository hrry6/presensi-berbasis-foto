@extends('layout.layout')
@section('judul', 'Akun Siswa')
@section('sidenav')
    <nav id="sidebarMenu" class="d-lg-block sidebar collapse bg-white">
        <div class="position-sticky">
            <div class="list-group list-group-flush mx-3 mt-4">
                <a href="/tata-usaha/dashboard" class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4" aria-current="true">
                    <img src="{{ asset('img/icon_Home.svg')}}" alt=""><span>Dashboard</span>
                </a>
                <a href="/tata-usaha/akun-guru" class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4">
                    <img src="{{ asset('img/icon_Profile.svg')}}" alt=""><span>Akun Guru</span>
                </a>
                <a href="/tata-usaha/akun-pengurus-kelas" class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4">
                    <img src="{{ asset('img/icon_Profile.svg')}}" alt=""><span>Akun Pengurus Kelas</span>
                </a>
                <a href="/tata-usaha/akun-siswa" class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4 active">
                    <img src="{{ asset('img/icon_Profile_White.svg')}}" alt=""><span>Akun Siswa</span>
                </a>
                <a href="/tata-usaha/presensi" class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4">
                    <img src="{{ asset('img/icon_Location.svg')}}" alt=""><span>Presensi</span>
                </a>
                <a href="/tata-usaha/logs" class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4">
                    <img src="{{ asset('img/icon_Book.svg')}}" alt=""><span>Logs</span>
                </a>
            </div>
        </div>
    </nav>
@endsection
@section('isi')
    <div class="mt-4 ml-4 pt-3 container-md bg-white">
        <div class="d-flex width-full justify-content-between mb-3">
            <form action="">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search Siswa....">
                    <div class="input-group-append">
                      <button class="input-group-text bg-primary" >
                        <img src="/img/icon_Search.svg" alt="">
                      </button>
                    </div>
                  </div>
            </form>
            <a href="tambah-siswa" class="btn btn-warning text-dark">Tambah Akun Siswa</a>
        </div>
        <table class="table table-bordered DataTable">
            <thead class="thead table-dark">
                <tr class="">
                    <th scope="col">No</th>
                    <th scope="col">Foto</th>
                    <th scope="col">NIS</th>
                    <th scope="col">Nama Lengkap</th>
                    <th scope="col">Jenkel</th>
                    <th scope="col">Kelas</th>
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
                                    style="max-width: 100px; height: auto;" />
                            @endif
                        </td>
                        <td>{{ $i->nis }}</td>
                        <td>{{ $i->nama_siswa }}</td>
                        <td>{{ $i->jenis_kelamin }}</td>
                        <th>{{ $i->tingkatan . ' ' . $i->nama_jurusan . ' ' . $i->nama_kelas }}</th>
                        <td>
                            <a href="/tata-usaha/detail-siswa/{{ $i->id_siswa }}" class="btn btn-primary">
                                <img src="{{ asset('img/icon_Search.svg')}}" alt="">
                            </a>
                            <a href="/tata-usaha/edit-siswa/{{ $i->id_siswa }}" class="btn btn-warning">
                                <img src="{{ asset('img/icon_Edit.svg')}}" alt="">
                            </a>
                            <btn class="btn btn-danger btnHapus" idHapus="{{ $i->id_siswa }}">
                                <img src="{{ asset('img/icon_Trash.svg')}}" alt="">
                            </btn>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

@endsection

@section('footer')
    <script type="module">
        $('.DataTable tbody').on('click', '.btnHapus', function(a) {
            a.preventDefault();
            let idHapus = $(this).closest('.btnHapus').attr('idHapus');
            swal.fire({
                title: "Apakah anda ingin menghapus data ini?",
                showCancelButton: true,
                confirmButtonText: 'Setuju',
                cancelButtonText: `Batal`,
                confirmButtonColor: 'red'

            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'DELETE',
                        url: 'hapus-siswa',
                        data: {
                            id_siswa: idHapus,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            if (data.success) {
                                swal.fire('Berhasil di hapus!', '', 'success').then(function() {
                                    //Refresh Halaman
                                    location.reload();
                                });
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection
