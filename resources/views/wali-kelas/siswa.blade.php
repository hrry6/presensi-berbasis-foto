@extends('layout.layout')
@section('judul', 'Dashboard Wali Kelas')
@section('sidenav')
    <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
        <div class="position-sticky">
            <div class="list-group list-group-flush mx-3 mt-4">
                <a href="#" class="list-group-item list-group-item-action py-2 ripple" aria-current="true">
                    <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>Dashboard</span>
                </a>
                <a href="#" class="list-group-item list-group-item-action py-2 ripple">
                    <i class="fas fa-chart-area fa-fw me-3"></i><span>Akun Pengurus Kelas</span>
                </a>
                <a href="#" class="list-group-item list-group-item-action py-2 ripple active">
                    <i class="fas fa-chart-area fa-fw me-3"></i><span>Akun Siswa</span>
                </a>
                <a href="#" class="list-group-item list-group-item-action py-2 ripple">
                    <i class="fas fa-chart-area fa-fw me-3"></i><span>Presensi</span>
                </a>
            </div>
        </div>
    </nav>
@endsection
@section('isi')
    <div class="mt-4 ml-4 pt-3 container-md bg-white">
        <div class="d-flex width-full justify-content-between mb-3">
            <form action="">
                <input type="text" placeholder="Search Siswa">
                <button class="position-relative">Search</button>
            </form>
            <a href="/wali-kelas/tambah-siswa" class="btn btn-warning text-dark">Tambah Akun Siswa</a>
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
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if ($i->foto_siswa)
                                <img src="{{ url('foto') . '/' . $i->foto_siswa }} "
                                    style="max-width: 100px; height: auto;" />
                            @endif
                        </td>
                        <td>{{ $i->nis }}</td>
                        <td>{{ $i->nama_siswa }}</td>
                        <td>{{ $i->jenis_kelamin }}</td>
                        <td>{{ $i->kelas->nama_kelas }}</td>
                        <td>
                            <a href="edit-siswa/{{ $i->id_siswa }}" class="btn btn-success">EDIT</a>
                            <btn class="btn btn-danger btnHapus" idHapus="{{ $i->id_siswa }}">HAPUS</btn>
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
