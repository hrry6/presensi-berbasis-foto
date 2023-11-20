<!DOCTYPE html>
<html>

<head>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> --}}
    <title>@yield('judul')</title>
    <!-- Laravel Notify -->
    @notifyCss
    <style>
        body {
            background-color: '#F8F8F8';
        }

        @media (min-width: 991.98px) {
            main {
                padding-left: 240px;
            }
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            padding: 58px 0 0;
            /* Height of navbar */
            box-shadow: 0 2px 5px 0 rgb(0 0 0 / 5%), 0 2px 10px 0 rgb(0 0 0 / 5%);
            width: 280px;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                width: 100%;
            }
        }

        .sidebar .active {
            border-radius: 5px;
            box-shadow: 0 2px 5px 0 rgb(0 0 0 / 16%), 0 2px 10px 0 rgb(0 0 0 / 12%);
        }

        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 48px);
            padding-top: 0.5rem;
            overflow-x: hidden;
            overflow-y: auto;
            /* Scrollable contents if viewport is shorter than content. */
        }

        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .icon {
            width: 27px;
            height: 27px;
        }

        .block {
            padding: 50px
        }

        .navbar {
            z-index: 100 !important;
        }
        .title{
            color: 292D32;
            font-size: 18px;
        }

        .img-profile
        {
            width: 42px !important;
            height: 42px !important;
            border-radius: 100px
        }
        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
</head>

<body>
    <!-- Laravel Notify -->
    <div class="notify" style="z-index: 999; position: absolute; display: block">
        @include('notify::components.notify')
        @notifyJs
    </div>

    <!--Main Navigation-->
    <header>
        <!-- Sidebar -->
        @yield('sidenav')
        <!-- Sidebar -->

        <!-- Navbar -->
        <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top border border-dark-subtle"
            style="z-index: 0;">
            <!-- Container wrapper -->
            <div class="container-fluid">
                <!-- Toggle button -->
                <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#sidebarMenu"
                    aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
                <!-- Your navbar content -->

                <!-- Brand -->
                <a class="navbar-brand" href="#">
                    <img src="/img/logo.png" width="150" alt="" loading="lazy" />
                </a>

                <h1 class="title">@yield('judul')</h1>
                <!-- Right links -->
                <ul class="navbar-nav ms-auto d-flex flex-row gap-3">
                    <a href="/logout" class="btn btn-danger flex gap-2 justify-center items-center">
                        <p class="p-0 m-0">LOG OUT</p>
                        <img class="icon" src="{{ asset('img/icon_Logout.svg') }}" alt="">
                    </a>
                    @if(Auth::user()->id_role == '1')
                    <a href="/siswa/detail-profil/{{ Auth::user()->id_akun }}">
                        <li class="nav-item dropdown p-10">
                            <img class="img-profile" src="{{ url('siswa') . '/' . App\Models\Siswa::where('id_akun', Auth::user()->id_akun)->first()->foto_siswa }}" class="rounded-circle"
                            height="42" alt="" width="42" loading="lazy" />
                        </li>
                    </a>
                    @elseif(Auth::user()->id_role == '2')
                    <a href="/wali-kelas/detail-profil/{{ Auth::user()->id_akun }}">
                        <li class="nav-item dropdown w-full">
                            <img class="img-profile" src="{{ url('guru') . '/' . App\Models\Guru::where('id_akun', Auth::user()->id_akun)->first()->foto_guru }}" class="rounded-circle"
                            height="42" alt="" width="42" loading="lazy" />
                        </li>
                    </a>
                    @elseif(Auth::user()->id_role == '3')
                    <a href="/pengurus-kelas/detail-profil/{{ Auth::user()->id_akun }}">
                        <li class="nav-item dropdown p-10">
                            <img class="img-profile" src="{{ url('siswa') . '/' . App\Models\Siswa::where('id_akun', Auth::user()->id_akun)->first()->foto_siswa }}" class="rounded-circle"
                            height="42" alt="" width="42" loading="lazy" />
                        </li>
                    </a>
                    @elseif(Auth::user()->id_role == '4')
                        <a href="/guru-piket/detail-profil/{{ Auth::user()->id_akun }}">
                            <li class="nav-item dropdown p-10">
                                <img class="img-profile" src="{{ url('guru') . '/' . App\Models\Guru::where('id_akun', Auth::user()->id_akun)->first()->foto_guru }}" class="rounded-circle"
                                height="42" alt="" width="42" loading="lazy" />
                            </li>
                        </a>
                    @elseif(Auth::user()->id_role == '5')
                    <a href="/guru-bk/detail-profil/{{ Auth::user()->id_akun }}">
                        <li class="nav-item dropdown p-10">
                            <img class="img-profile" src="{{ url('guru') . '/' . App\Models\Guru::where('id_akun', Auth::user()->id_akun)->first()->foto_guru }}" class="rounded-circle"
                            height="42" alt="" width="42" loading="lazy" />
                        </li>
                    </a>
                    @endif
                </ul>
            </div>
            <!-- Container wrapper -->
        </nav>
        <!-- Navbar -->
    </header>
    <!--Main Navigation-->

    <!--Main layout-->
    <main style="margin-top: 58px">
        <div class="container p-5">
            @yield('isi')
        </div>
    </main>

    @yield('footer')
    <!--Main layout-->
</body>

</html>
