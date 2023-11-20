@extends('layout.layout')
@section('judul', 'Kelola Siswa')
@section('sidenav')
    <nav id="sidebarMenu" class="d-lg-block sidebar collapse bg-white">
        <div class="position-sticky">
            <div class="list-group list-group-flush mx-3 mt-4">
                <a href="/tata-usaha/dashboard"
                    class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4" aria-current="true">
                    <img src="{{ asset('img/icon_Home.svg') }}" alt=""><span>Dashboard</span>
                </a>
                <a href="/tata-usaha/jurusan"
                    class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4" aria-current="true">
                    <img src="{{ asset('img/icon_Jurusan.svg') }}" alt=""><span>Jurusan</span>
                </a>
                <a href="/tata-usaha/kelas?filter_status=aktif"
                    class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4" aria-current="true">
                    <img src="{{ asset('img/icon_Kelas.svg') }}" alt=""><span>Kelas</span>
                </a>
                <a href="/tata-usaha/akun-guru"
                    class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4">
                    <img src="{{ asset('img/icon_Profile.svg') }}" alt=""><span>Akun Guru</span>
                </a>
                <a href="/tata-usaha/akun-pengurus-kelas"
                    class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4">
                    <img src="{{ asset('img/icon_Profile.svg') }}" alt=""><span>Akun Pengurus Kelas</span>
                </a>
                <a href="/tata-usaha/akun-siswa?filter_status=aktif"
                    class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4 active">
                    <img src="{{ asset('img/icon_Profile_White.svg') }}" alt=""><span>Akun Siswa</span>
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
        <form action="" method="get" class="flex gap-3 flex-col w-auto mb-3" id="form">
            <div class=" flex w-full justify-content-between">
                <div class="flex">
                    <input type="text" class="form-control" style="width:200px !important" name="keyword"
                        value="{{ old('keyword', request('keyword')) }}" placeholder="Search Siswa....">
                    <div class="input-group-append mx-2">
                        <button class="input-group-text bg-primary">
                            <img src="/img/icon_Search.svg" alt="">
                        </button>
                    </div>
                </div>
                <a href="tambah-siswa" class="btn btn-primary">Tambah Akun Siswa</a>
            </div>
            <div class="flex gap-3">
                <select class="form-select filter" name="filter_jenkel" value="">
                    <option value="" {{ old('filter_jenkel', request('filter_jenkel')) == '' ? 'selected' : '' }}>
                        Pilih
                        Jankel</option>
                    <option value="laki-laki"
                        {{ old('filter_jenkel', request('filter_jenkel')) == 'laki-laki' ? 'selected' : '' }}>Laki-laki
                    </option>
                    <option value="perempuan"
                        {{ old('filter_jenkel', request('filter_jenkel')) == 'perempuan' ? 'selected' : '' }}>Perempuan
                    </option>
                </select>
                <select class="form-select filter" name="filter_kelas" value="">
                    <option value="" {{ old('filter_jurusan', request('filter_kelas')) == '' ? 'selected' : '' }}>
                        Pilih Kelas</option>
                    @foreach ($kelas as $k)
                        <option value="{{ $k->id_kelas }}"
                            {{ old('filter_kelas', request('filter_kelas')) == "$k->id_kelas" ? 'selected' : '' }}>
                            {{ $k->tingkatan." ".$k->nama_jurusan." ".$k->nama_kelas }}</option>
                    @endforeach
                </select>
                <select class="form-select filter {{ old('filter_status', request('filter_status')) == 'aktif' ? 'bg-success text-white' : '' }}
                {{ old('filter_status', request('filter_status')) == 'tidak_aktif' ? 'bg-danger text-white' : '' }}" name="filter_status" value="">
                    <option value="" {{ old('filter_status', request('filter_status')) == '' ? 'selected' : '' }}>
                        Pilih
                        Status</option>
                    <option value="aktif"
                        {{ old('filter_status', request('filter_status')) == 'aktif' ? 'selected' : '' }}>
                        Aktif</option>
                    <option value="tidak_aktif"
                        {{ old('filter_status', request('filter_status')) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif
                    </option>
                </select>
            </div>
        </form>
        <table class="table table-bordered DataTable">
            <thead class="thead table-dark">
                <tr class="">
                    <th scope="col">No</th>
                    <th scope="col">Foto</th>
                    <th scope="col">NIS</th>
                    <th scope="col">Nama Lengkap</th>
                    <th scope="col">Jenkel</th>
                    <th scope="col">Kelas</th>
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
                        <th>{{ $i->tingkatan . ' ' . $i->nama_jurusan . ' ' . $i->nama_kelas }}</th>
                        <td>{{ $i->status_siswa }}</td>
                        <td class="d-flex gap-2">
                            <a href="/tata-usaha/detail-siswa/{{ $i->id_siswa }}">
                                <img src="{{ asset('img/icon_Vector.svg') }}" alt="">
                            </a>
                            <a href="/tata-usaha/edit-siswa/{{ $i->id_siswa }}">
                                <img src="{{ asset('img/icon_Edit.svg') }}" alt="">
                            </a>
                            <button class="btnHapus" idHapus="{{ $i->id_siswa }}">
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
        $(".filter").on('change', function() {
            $("#form").submit();
        })
    </script>
@endsection
