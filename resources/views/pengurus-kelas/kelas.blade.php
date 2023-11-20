@extends('layout.layout')
@section('judul', 'Dashboard Kelas')
<style>
    .block {
        padding: 100px;
        text-align: center;
        border-radius: 20px
    }

    .color-text {
        color: #F9812A;
    }

    .table-container {
        width: 100%;
    }
</style>
@section('sidenav')
    <nav id="sidebarMenu" class="collapse d-lg-block sidebar bg-white">
        <div class="position-sticky">
            <div class="list-group list-group-flush mx-3 mt-4">
                <a href="/pengurus-kelas/dashboard"
                    class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4" aria-current="true">
                    <img src="{{ asset('img/icon_Home.svg') }}" alt=""><span>Dashboard</span>
                </a>
                <a href="/pengurus-kelas/presensi" class="list-group-item list-group-item-action py-2 ripple">
                    <i class="fas fa-chart-area fa-fw me-3"></i><span>Presensi</span>
                </a>
                <a href="/pengurus-kelas/kelas" class="list-group-item list-group-item-action py-2 ripple active">
                    <i class="fas fa-chart-area fa-fw me-3"></i><span>Kelas</span>
                </a>
                <a href="/pengurus-kelas/histori" class="list-group-item list-group-item-action py-2 ripple">
                    <i class="fas fa-chart-area fa-fw me-3"></i><span>Histori</span>
                </a>
            </div>
        </div>
    </nav>
@endsection
@section('isi')
    <div class="mt-4 ml-4 pt-3 container-md bg-white">
        <form id="validasiForm" action="{{ url('kelas') }}" method="GET">
            @csrf
            <div class="d-flex">
                <div class="w-25">
                    <label for="waktu_validasi">Pilih Waktu Validasi:</label>
                    <select id="waktu_validasi" name="waktu_validasi" class="form-control">
                        <option value="istirahat_pertama">Istirahat Pertama</option>
                        <option value="istirahat_kedua">Istirahat Kedua</option>
                        <option value="istirahat_ketiga">Istirahat Ketiga</option>
                    </select>
                </div>
                <div class="ml-auto mt-4 mx-5">
                    <button type="submit" class="bg-primary p-2 text-white rounded-md"
                        style="width: 100px;">Submit</button>
                </div>
            </div>
            <div class="table-container mt-4">
                <table class="table table-bordered DataTable">
                    <thead class="thead table-dark">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">NIS</th>
                            <th scope="col">Nama Siswa</th>
                            <th scope="col" colspan="3" class="text-center">Kehadiran</th>
                        </tr>
                        <tr class="text-center">
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Hadir</th>
                            <th>Izin</th>
                            <th>Alpha</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($data as $i)
                            <tr class="data-row" data-waktu-validasi="{{ $i->waktu_validasi }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $i->nis }}</td>
                                <td>{{ $i->nama_siswa }}</td>
                                <td class="text-center">
                                    <input type="checkbox" class="single-checkbox"
                                        name="status_validasi[{{ $loop->iteration }}][]" value="hadir"
                                        id="checkbox_hadir_{{ $loop->iteration }}"
                                        {{ $i->status_validasi === 'hadir' ? 'checked' : '' }}>
                                    <input type="hidden" name="id_pengurus[{{ $loop->iteration }}]"
                                        value="{{ $i->id_pengurus }}">
                                    <input type="hidden" name="id_presensi[{{ $loop->iteration }}]"
                                        value="{{ $i->id_presensi }}">
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" class="single-checkbox"
                                        name="status_validasi[{{ $loop->iteration }}][]" value="izin"
                                        id="checkbox_izin_{{ $loop->iteration }}"
                                        {{ $i->status_validasi === 'izin' ? 'checked' : '' }}>
                                    <input type="hidden" name="id_pengurus[{{ $loop->iteration }}]"
                                        value="{{ $i->id_pengurus }}">
                                    <input type="hidden" name="id_presensi[{{ $loop->iteration }}]"
                                        value="{{ $i->id_presensi }}">
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" class="single-checkbox"
                                        name="status_validasi[{{ $loop->iteration }}][]" value="alpha"
                                        id="checkbox_alpha_{{ $loop->iteration }}"
                                        {{ $i->status_validasi === 'alpha' ? 'checked' : '' }}>
                                    <input type="hidden" name="id_pengurus[{{ $loop->iteration }}]"
                                        value="{{ $i->id_pengurus }}">
                                    <input type="hidden" name="id_presensi[{{ $loop->iteration }}]"
                                        value="{{ $i->id_presensi }}">
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>
    </div>

@endsection

@section('footer')
    <script type="module">
        $(document).ready(function() {
            function filterTable() {
                var selectedValue = $('#waktu_validasi').val();

                if (selectedValue === "") {
                    $('table.DataTable tbody tr').show();
                    return;
                }

                var rowsToShow = $('table.DataTable tbody tr[data-waktu-validasi="' + selectedValue + '"]');

                if (rowsToShow.length > 0) {
                    $('table.DataTable tbody tr').hide();
                    rowsToShow.show();
                }
            }

            filterTable();

            $('#waktu_validasi').change(function() {
                filterTable();
            });

            $('#validasiForm').submit(function(event) {
                if (event.originalEvent) {
                    $(this).attr('action', 'update-validasi');
                    $(this).attr('method', 'POST');
                }
            });

            $('.single-checkbox').on('change', function() {
                var checkboxes = $(this).closest('tr').find('.single-checkbox');

                checkboxes.prop('checked', false);

                $(this).prop('checked', true);
            });
        });
    </script>
@endsection
