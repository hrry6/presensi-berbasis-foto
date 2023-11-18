@extends('layout.layout')
@section('judul', 'Dashboard Siswa')

@section('sidenav')
    <nav id="sidebarMenu" class="collapse d-lg-block sidebar bg-white">
        <div class="position-sticky">
            <div class="list-group list-group-flush mx-3 mt-4">
                <a href="/pengurus-kelas/dashboard"
                    class="list-group-item list-group-item-action py-2 ripple flex items-center gap-4 active"
                    aria-current="true">
                    <img src="{{ asset('img/icon_Home.svg') }}" alt=""><span>Dashboard</span>
                </a>
                <a href="/pengurus-kelas/presensi" class="list-group-item list-group-item-action py-2 ripple">
                    <i class="fas fa-chart-area fa-fw me-3"></i><span>Presensi</span>
                </a>
                <a href="/pengurus-kelas/kelas" class="list-group-item list-group-item-action py-2 ripple">
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
    <div class="container mt-5">
        <form method="POST" action="{{ route('webcam.capture') }}" id="presensiForm">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div id="my_camera"></div>
                    <br />
                    <input type="button" value="Take Snapshot" onClick="takeSnapshotWithCheck()"
                        class="bg-primary p-2 text-white rounded-md" style="margin-left: 10px">
                    <input type="hidden" name="image" class="image-tag">
                    <input type="hidden" name="id_siswa" value="{{ $siswa->id_siswa }}">
                </div>
                <div class="col-md-6">
                    <div id="results">Hasil foto akan berada disini</div>
                </div>
                <div class="col-md-12 text-center">
                    <br />
                    <button class="btn btn-success px-3 submit-btn" disabled>Submit</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <script>
        Webcam.set({
            width: 490,
            height: 350,
            image_format: 'jpeg',
            jpeg_quality: 90
        });

        Webcam.attach('#my_camera');

        function takeSnapshotWithCheck() {
            var hasSubmitted = '{{ session('snapshot_taken') }}';
            if (hasSubmitted) {
                showErrorMessage("Anda sudah melakukan Presensi.");
            } else {
                checkIfSnapshotAlreadyTaken();
            }
        }

        function checkIfSnapshotAlreadyTaken() {
            $.ajax({
                url: '{{ route('webcam.check_snapshot') }}',
                type: 'POST',
                data: {
                    id_siswa: '{{ $siswa->id_siswa }}',
                    _token: '{{ csrf_token() }}'
                },
                success: function(result) {
                    if (result.exists) {
                        showErrorMessage("Anda sudah melakukan Presensi.");
                    } else {
                        take_snapshot();
                        enableSubmitButton();
                        @php session(['snapshot_taken' => true]) @endphp
                        setTimeout(function() {
                            // Destroy after 13 hours
                            @php session()->forget('snapshot_taken') @endphp
                        }, 13 * 60 * 60 * 1000);

                    }
                }
            });
        }

        function take_snapshot() {
            Webcam.snap(function(data_uri) {
                $(".image-tag").val(data_uri);
                document.getElementById('results').innerHTML = '<img src="' + data_uri + '"/>';
            });
        }

        function enableSubmitButton() {
            document.querySelector('.submit-btn').removeAttribute('disabled');
        }

        function showErrorMessage(message) {
            swal.fire({
                icon: "error",
                title: "Terjadi Kesalahan",
                text: message,
                showCancelButton: false,
                showConfirmButton: false
            });
        }
    </script>

    <script type="module">
        $('.submit-btn').click(function(event) {
            event.preventDefault();

            swal.fire({
                title: "Berhasil!",
                text: "Berhasil Melakukan Presensi!",
                icon: "success",
                showCancelButton: false,
                showConfirmButton: false
            });

            setTimeout(function() {
                document.getElementById('presensiForm').submit();
            }, 2000);
        });
    </script>
@endsection
