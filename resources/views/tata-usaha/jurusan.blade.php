@extends('layout.layout')
@section('judul', 'Kelola Jurusan')
@section('sidenav')
    <nav id="sidebarMenu" class="d-lg-block sidebar collapse bg-white">
        <div class="position-sticky">
            <div class="list-group list-group-flush mx-3 mt-4">
                <a href="/tata-usaha/dashboard"
                    class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4" aria-current="true">
                    <img src="{{ asset('img/icon_Home.svg') }}" alt=""><span>Dashboard</span>
                </a>
                <a href="/tata-usaha/jurusan"
                    class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4 active"
                    aria-current="true">
                    <img src="{{ asset('img/icon_Jurusan_White.svg') }}" alt=""><span>Jurusan</span>
                </a>
                <a href="/tata-usaha/kelas"
                    class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4" aria-current="true">
                    <img src="{{ asset('img/icon_Kelas.svg') }}" alt=""><span>Kelas</span>
                </a>
                <a href="/tata-usaha/akun-guru"
                    class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4">
                    <img src="{{ asset('img/icon_Profile.svg') }}" alt=""><span>Guru</span>
                </a>
                <a href="/tata-usaha/akun-pengurus-kelas"
                    class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4">
                    <img src="{{ asset('img/icon_Profile.svg') }}" alt=""><span>Pengurus Kelas</span>
                </a>
                <a href="/tata-usaha/akun-siswa"
                    class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4">
                    <img src="{{ asset('img/icon_Profile.svg') }}" alt=""><span>Siswa</span>
                </a>
                <a href="/tata-usaha/presensi"
                    class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4">
                    <img src="{{ asset('img/icon_Location.svg') }}" alt=""><span>Presensi</span>
                </a>
                <a href="/tata-usaha/logs"
                    class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4">
                    <img src="{{ asset('img/icon_Book.svg') }}" alt=""><span>Logs</span>
                </a>
            </div>
        </div>
    </nav>
@endsection
@section('isi')
    <div class="mt-4 ml-4 pt-3 container-md bg-white">
        <div class="d-flex width-full justify-content-between mb-3">
            <form action="" method="get" class="flex gap-3" id="form">
                <div class="input-group">
                    <input type="text" class="form-control" name="keyword" placeholder="Search Jurusan...."
                        value="{{ old('keyword', request('keyword')) }}">
                    <div class="input-group-append mx-2">
                        <button class="input-group-text bg-primary">
                            <img src="/img/icon_Search.svg" alt="">
                        </button>
                    </div>
                </div>
            </form>
            <a href="tambah-jurusan" class="btn btn-primary text-white">Tambah Jurusan</a>
        </div>
        <table class="table table-bordered DataTable">
            <thead class="thead table-dark">
                <tr class="">
                    <th scope="col">No</th>
                    <th scope="col">Jurusan</th>
                    <th scope="col" style="width:115px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jurusan as $j)
                    <tr>
                        <th>{{ $loop->iteration }}</th>
                        <th>{{ $j->nama_jurusan }}</th>
                        <td class="d-flex justify-content-center gap-2">
                            <a href="/tata-usaha/edit-jurusan/{{ $j->id_jurusan }}">
                                <img src="{{ asset('img/icon_Edit.svg') }}" alt="">
                            </a>
                            <button class="btnHapus" idHapus="{{ $j->id_jurusan }}">
                                <img src="{{ asset('img/icon_Trash.svg') }}" alt="">
                            </button>
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
                        url: 'hapus-jurusan',
                        data: {
                            id_jurusan: idHapus,
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

        $(".filter").on('change', function() {
            $("#form").submit();
        })
    </script>
@endsection
