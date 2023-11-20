@extends('layout.layout')
@section('judul', 'Pengurus Kelas')
@section('sidenav')
    <nav id="sidebarMenu" class="collapse d-lg-block sidebar bg-white">
        <div class="position-sticky">
            <div class="list-group list-group-flush mx-3 mt-4">
                <a href="{{ url('wali-kelas/dashboard') }}"
                    class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4" aria-current="true">
                    <img src="{{ asset('img/icon_Home.svg') }}" alt=""><span>Dashboard</span>
                </a>
                <a href="{{ url('wali-kelas/akun-pengurus-kelas') }}"
                    class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4 active">
                    <img src="{{ asset('img/icon_Profile_White.svg') }}" alt=""><span>Pengurus Kelas</span>
                </a>
                <a href="{{ url('wali-kelas/akun-siswa') }}"
                    class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4">
                    <img src="{{ asset('img/icon_Profile.svg') }}" alt=""><span>Siswa</span>
                </a>
                <a href="{{ url('wali-kelas/presensi-siswa') }}"
                    class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4">
                    <img src="{{ asset('img/icon_Location.svg') }}" alt=""><span>Presensi</span>
                </a>
                <a href="{{ url('wali-kelas/logs') }}"
                    class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4">
                    <img src="{{ asset('img/icon_Book.svg') }}" alt=""><span>Logs</span>
                </a>
            </div>
        </div>
    </nav>
@endsection
@section('isi')
    <div class="mt-4 ml-4 pt-3 container-md bg-white">
        <form action="" method="get" class="flex gap-3 flex-col w-auto mb-3" id="form">
            <div class=" flex w-full justify-content-between">
                <div class="flex">
                    <input type="text" class="form-control" style="width:200px !important" name="keyword"
                        value="{{ old('keyword', request('keyword')) }}" placeholder="Search Pengurus Kelas....">
                    <div class="input-group-append mx-2">
                        <button class="input-group-text bg-primary">
                            <img src="/img/icon_Search.svg" alt="">
                        </button>
                    </div>
                </div>
                <a href="tambah-pengurus-kelas" class="btn btn-primary">Tambah Pengurus Kelas</a>
            </div>
            <div class="w-25">
                <select class="form-select filter" name="filter_jabatan" value="">
                    <option value="" {{ old('filter_jabatan', request('filter_jabatan')) == '' ? 'selected' : '' }}>
                        Pilih
                        Jabatan</option>
                    <option value="ketua_kelas"
                        {{ old('filter_jabatan', request('filter_jabatan')) == 'ketua_kelas' ? 'selected' : '' }}>
                        Ketua
                        Kelas
                    </option>
                    <option value="wakil_kelas"
                        {{ old('filter_jabatan', request('filter_jabatan')) == 'wakil_kelas' ? 'selected' : '' }}>
                        Wakil
                        Kelas
                    </option>
                    <option value="sekertaris"
                        {{ old('filter_jabatan', request('filter_jabatan')) == 'sekertaris' ? 'selected' : '' }}>
                        Sekertaris
                    </option>
                </select>
            </div>
        </form>
        <table class="table table-bordered DataTable">
            <thead class="thead table-dark">
                <tr class="">
                    <th scope="col">No</th>
                    <th scope="col">Nama Lengkap</th>
                    <th scope="col">NIS</th>
                    <th scope="col">Jabatan</th>
                    <th scope="col">Kelas</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pengurus as $i)
                    <tr>
                        <th>{{ $loop->iteration }}</th>
                        <td>{{ $i->nama_siswa }}</td>
                        <th>{{ $i->nis }}</th>
                        <th>{{ $i->status_jabatan }}</th>
                        <td>{{ $i->nama_kelas }}</td>
                        <td class="d-flex justify-content-around align-items-center">
                            <a href="/wali-kelas/detail-siswa-pengurus/{{ $i->id_siswa }}">
                                <img src="{{ asset('img/icon_Vector.svg') }}" alt="">
                            </a>
                            <a href="/wali-kelas/edit-pengurus-kelas/{{ $i->id_siswa }}">
                                <img src="{{ asset('img/icon_Edit.svg') }}" alt="">
                            </a>
                            <button class="btnHapus" idHapus="{{ $i->id_pengurus }}">
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
                    console.log(idHapus)
                    $.ajax({
                        type: 'DELETE',
                        url: '/wali-kelas/hapus-pengurus-kelas',
                        data: {
                            id_pengurus: idHapus,
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
