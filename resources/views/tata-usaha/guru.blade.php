@extends('layout.layout')
@section('judul', 'Akun Guru')
@section('sidenav')
    <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
        <div class="position-sticky">
            <div class="list-group list-group-flush mx-3 mt-4">
                <a href="/tata-usaha/dashboard" class="list-group-item list-group-item-action py-2 ripple" aria-current="true">
                    <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>Dashboard</span>
                </a>
                <a href="/tata-usaha/akun-guru" class="list-group-item list-group-item-action py-2 ripple active">
                    <i class="fas fa-chart-area fa-fw me-3"></i><span>Akun Guru</span>
                </a>
                <a href="/tata-usaha/akun-pengurus-kelas" class="list-group-item list-group-item-action py-2 ripple">
                    <i class="fas fa-chart-area fa-fw me-3"></i><span>Akun Pengurus Kelas</span>
                </a>
                <a href="/tata-usaha/akun-siswa" class="list-group-item list-group-item-action py-2 ripple">
                    <i class="fas fa-chart-area fa-fw me-3"></i><span>Akun Siswa</span>
                </a>
                <a href="/tata-usaha/presensi" class="list-group-item list-group-item-action py-2 ripple">
                    <i class="fas fa-chart-area fa-fw me-3"></i><span>Presensi</span>
                </a>
                <a href="/tata-usaha/logs" class="list-group-item list-group-item-action py-2 ripple">
                    <i class="fas fa-chart-area fa-fw me-3"></i><span>Logs</span>
                </a>
            </div>
        </div>
    </nav>
@endsection
@section('isi')
    <div class="mt-4 ml-4 pt-3 container-md bg-white">
        <div class="d-flex width-full justify-content-between mb-3">
            <form action="tambah-guru">
                <input type="text" placeholder="Search Guru">
                <button class="position-relative">Search</button>
            </form>
            <a href="tambah-guru" class="btn btn-warning text-dark">Tambah Akun Guru</a>
        </div>
        <table class="table table-bordered DataTable">
            <thead class="thead table-dark">
                <tr class="">
                    <th scope="col">No</th>
                    <th scope="col">Foto</th>
                    <th scope="col">Nama Guru</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $index = 1;
                @endphp
                @foreach ($guruBK as $i)
                    <tr>
                        <td>{{ $index++ }}</td>
                        <td>
                            @if ($i->foto_guru)
                                <img src="{{ url('guru') . '/' . $i->foto_guru }} "
                                    style="max-width: 100px; height: auto;" />
                            @endif
                        </td>
                        <th>{{ $i->nama_guru }}</th>
                        <th>Guru BK</th>
                        <td>
                            <a href="/tata-usaha/edit-guru/{{ $i->id_guru }}" class="btn btn-success">EDIT</a>
                            <btn class="btn btn-danger btnHapus" idHapus="{{ $i->id_guru }}">HAPUS</btn>
                        </td>
                    </tr>
                @endforeach
                @foreach ($guruPiket as $p)
                    <tr>
                        <td>{{ $index++ }}</td>
                        <td>
                            @if ($p->foto_guru)
                                <img src="{{ url('guru') . '/' . $p->foto_guru }} "
                                    style="max-width: 100px; height: auto;" />
                            @endif
                        </td>
                        <th>{{ $p->nama_guru }}</th>
                        <th>Guru Piket</th>
                        <td>
                            <a href="/tata-usaha/edit-guru/{{ $p->id_guru }}" class="btn btn-success">EDIT</a>
                            <btn class="btn btn-danger btnHapus" idHapus="{{ $p->id_guru }}">HAPUS</btn>
                        </td>
                    </tr>
                @endforeach
                @foreach ($kelas as $k)
                    <tr>
                        <td>{{ $index++ }}</td>
                        <td>
                            @if ($k->foto_guru)
                                <img src="{{ url('guru') . '/' . $k->foto_guru }} "
                                    style="max-width: 100px; height: auto;" />
                            @endif
                        </td>
                        <th>{{ $k->nama_guru }}</th>
                        <th>Wali Kelas {{ $k->tingkatan . ' ' . $k->nama_jurusan . ' ' . $k->nama_kelas }}</th>
                        <td>
                            <a href="/tata-usaha/edit-guru/{{ $k->id_guru }}" class="btn btn-success">EDIT</a>
                            <btn class="btn btn-danger btnHapus" idHapus="{{ $k->id_guru }}">HAPUS</btn>
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
                        url: 'hapus-guru',
                        data: {
                            id_guru: idHapus,
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
