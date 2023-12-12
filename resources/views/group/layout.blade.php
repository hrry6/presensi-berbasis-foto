<html>

<head>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <title>@yield('judul')</title>
    <style>
        body {
            background-color: '#F8F8F8';
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            display: none;
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
            width: 240px;
            z-index: 600;
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

        .title {
            padding: 0 !important;
            margin-top: auto !important;
            margin-bottom: auto !important;
            color: 292D32;
            font-size: 20px;
        }
    </style>
</head>

<body>

    <!--Main Navigation-->
    <header>
        <!-- Sidebar -->
        @yield('sidenav')
        <!-- Sidebar -->

        <!-- Navbar -->
        <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top border border-dark-subtle">
            <!-- Container wrapper -->
            <div class="container-fluid">
                <!-- Toggle button -->
                <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#sidebarMenu"
                    aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Brand -->
                <a class="navbar-brand" href="#">
                    <img src="/img/logo.png" width="150" alt="" loading="lazy" />
                </a>

                {{-- <h1 class="title">@yield('judul')</h1> --}}
                <!-- Right links -->
                <ul class="navbar-nav ms-auto d-flex flex-row">
                    <a href="/logout" class="btn btn-danger">
                        Logout
                        <img class="icon" src="{{ asset('img/icon_Logout.svg') }}" alt="">
                    </a>
                    @if (Auth::user()->id_role == '4')
                        <a href="/guru-piket/detail-profil/{{ Auth::user()->id_akun }}">
                            <li class="nav-item dropdown p-10">
                                <img src="{{ url('guru') . '/' . App\Models\Guru::where('id_akun', Auth::user()->id_akun)->first()->foto_guru }}"
                                    class="rounded-circle" height="42" alt="" width="42"
                                    loading="lazy" />
                            </li>
                        </a>
                    @elseif(Auth::user()->id_role == '5')
                        <a href="/guru-bk/detail-profil/{{ Auth::user()->id_akun }}">
                            <li class="nav-item dropdown p-10">
                                <img src="{{ url('guru') . '/' . App\Models\Guru::where('id_akun', Auth::user()->id_akun)->first()->foto_guru }}"
                                    class="rounded-circle" height="42" alt="" width="42"
                                    loading="lazy" />
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
    <div style="margin-top: 90px ">
        @yield('isi')
    </div>

    @yield('footer')
    <!--Main layout-->
</body>

</html>
