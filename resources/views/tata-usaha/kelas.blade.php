@extends('layout.layout')
@section('judul', 'Kelola Kelas')
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
                    class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4 active"
                    aria-current="true">
                    <img src="{{ asset('img/icon_Kelas_White.svg') }}" alt=""><span>Kelas</span>
                </a>
                <a href="/tata-usaha/akun-guru"
                    class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4">
                    <img src="{{ asset('img/icon_Profile.svg') }}" alt=""><span>Guru</span>
                </a>
                <a href="/tata-usaha/akun-pengurus-kelas"
                    class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4">
                    <img src="{{ asset('img/icon_Profile.svg') }}" alt=""><span>Pengurus Kelas</span>
                </a>
                <a href="/tata-usaha/akun-siswa?filter_status=aktif"
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
        <form action="" method="get" class="flex gap-3 flex-col w-auto mb-3" id="form">
            <div class=" flex w-full justify-content-between">
                <div class="flex">
                    <input type="text" class="form-control" style="width:200px !important" name="keyword"
                        value="{{ old('keyword', request('keyword')) }}" placeholder="Search Kelas....">
                    <div class="input-group-append mx-2">
                        <button class="input-group-text bg-primary">
                            <img src="/img/icon_Search.svg" alt="">
                        </button>
                    </div>
                </div>
                <a href="tambah-kelas" class="btn btn-primary">Tambah Kelas</a>
            </div>
            <div class="flex gap-3">
                <select class="form-select filter" name="filter_tingkatan" value="">
                    <option value=""
                        {{ old('filter_tingkatan', request('filter_tingkatan')) == '' ? 'selected' : '' }}>
                        Pilih Tingkatan</option>
                    <option value="X"
                        {{ old('filter_tingkatan', request('filter_tingkatan')) == 'X' ? 'selected' : '' }}>
                        X</option>
                    <option value="XI"
                        {{ old('filter_tingkatan', request('filter_tingkatan')) == 'XI' ? 'selected' : '' }}>XI</option>
                    <option value="XII"
                        {{ old('filter_tingkatan', request('filter_tingkatan')) == 'XII' ? 'selected' : '' }}>XII</option>
                </select>
                <select class="form-select filter" name="filter_jurusan" value="">
                    <option value="" {{ old('filter_jurusan', request('filter_jurusan')) == '' ? 'selected' : '' }}>
                        Pilih
                        Jurusan</option>
                    @foreach ($jurusan as $j)
                        <option value="{{ $j->id_jurusan }}"
                            {{ old('filter_jurusan', request('filter_jurusan')) == "$j->id_jurusan" ? 'selected' : '' }}>
                            {{ $j->nama_jurusan }}</option>
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
                    <th scope="col">Tingkatan</th>
                    <th scope="col">Jurusan</th>
                    <th scope="col">Nama Kelas</th>
                    <th scope="col">Status</th>
                    <th scope="col" style="width:115px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kelas as $k)
                    <tr>
                        <th>{{ $loop->iteration }}</th>
                        <td>{{ $k->tingkatan }}</td>
                        <td>{{ $k->nama_jurusan }}</td>
                        <td>{{ $k->nama_kelas }}</td>
                        <td>{{ $k->status_kelas }}</td>
                        <td class="d-flex justify-content-center gap-2">
                            <a href="/tata-usaha/detail-kelas/{{ $k->id_kelas }}">
                                <img src="{{ asset('img/icon_Vector.svg') }}" alt="">
                            </a>
                            <a href="/tata-usaha/edit-kelas/{{ $k->id_kelas }}">
                                <img src="{{ asset('img/icon_Edit.svg') }}" alt="">
                            </a>
                            <button class="btnHapus" idHapus="{{ $k->id_kelas }}">
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
                        url: 'hapus-kelas',
                        data: {
                            id_kelas: idHapus,
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
