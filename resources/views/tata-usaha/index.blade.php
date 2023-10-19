<html>

<head>
    @vite(['resources/sass/app.scss','resources/js/app.js'])
    <title>@yield('Judul Halaman')</title>
    <style>
      body {
  background-color: #fbfbfb;
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
  padding: 58px 0 0; /* Height of navbar */
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
  overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
}
    </style>
  </head>
<body>

    <!--Main Navigation-->
    <header>
        <!-- Sidebar -->
        <nav
             id="sidebarMenu"
             class="collapse d-lg-block sidebar collapse bg-white"
             >
          <div class="position-sticky">
            <div class="list-group list-group-flush mx-3 mt-4">
              <a
                 href="#"
                 class="list-group-item list-group-item-action py-2 ripple"
                 aria-current="true"
                 >
                <i class="fas fa-tachometer-alt fa-fw me-3"></i
                  ><span>Main dashboard</span>
              </a>
              <a
                 href="#"
                 class="list-group-item list-group-item-action py-2 ripple active"
                 >
                <i class="fas fa-chart-area fa-fw me-3"></i
                  ><span>Webiste traffic</span>
              </a>
              <a
                 href="#"
                 class="list-group-item list-group-item-action py-2 ripple"
                 ><i class="fas fa-lock fa-fw me-3"></i><span>Password</span></a
                >
              <a
                 href="#"
                 class="list-group-item list-group-item-action py-2 ripple"
                 ><i class="fas fa-chart-line fa-fw me-3"></i
                ><span>Analytics</span></a
                >
              <a
                 href="#"
                 class="list-group-item list-group-item-action py-2 ripple"
                 >
                <i class="fas fa-chart-pie fa-fw me-3"></i><span>SEO</span>
              </a>
              <a
                 href="#"
                 class="list-group-item list-group-item-action py-2 ripple"
                 ><i class="fas fa-chart-bar fa-fw me-3"></i><span>Orders</span></a
                >
              <a
                 href="#"
                 class="list-group-item list-group-item-action py-2 ripple"
                 ><i class="fas fa-globe fa-fw me-3"></i
                ><span>International</span></a
                >
              <a
                 href="#"
                 class="list-group-item list-group-item-action py-2 ripple"
                 ><i class="fas fa-building fa-fw me-3"></i
                ><span>Partners</span></a
                >
              <a
                 href="#"
                 class="list-group-item list-group-item-action py-2 ripple"
                 ><i class="fas fa-calendar fa-fw me-3"></i
                ><span>Calendar</span></a
                >
              <a
                 href="#"
                 class="list-group-item list-group-item-action py-2 ripple"
                 ><i class="fas fa-users fa-fw me-3"></i><span>Users</span></a
                >
              <a
                 href="#"
                 class="list-group-item list-group-item-action py-2 ripple"
                 ><i class="fas fa-money-bill fa-fw me-3"></i><span>Sales</span></a
                >
            </div>
          </div>
        </nav>
        <!-- Sidebar -->
      
        <!-- Navbar -->
        <nav
             id="main-navbar"
             class="navbar navbar-expand-lg navbar-light bg-white fixed-top"
             >
          <!-- Container wrapper -->
          <div class="container-fluid">
            <!-- Toggle button -->
            <button
                    class="navbar-toggler"
                    type="button"
                    data-mdb-toggle="collapse"
                    data-mdb-target="#sidebarMenu"
                    aria-controls="sidebarMenu"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                    >
              <i class="fas fa-bars"></i>
            </button>
      
            <!-- Brand -->
            <a class="navbar-brand" href="#">
              <img
                   src="https://mdbootstrap.com/img/logo/mdb-transaprent-noshadows.png"
                   height="25"
                   alt=""
                   loading="lazy"
                   />
            </a>
      
            <!-- Right links -->
            <ul class="navbar-nav ms-auto d-flex flex-row">
              <!-- Notification dropdown -->
              <li class="nav-item dropdown">
                <a
                   class="nav-link me-3 me-lg-0 dropdown-toggle hidden-arrow"
                   href="#"
                   id="navbarDropdownMenuLink"
                   role="button"
                   data-mdb-toggle="dropdown"
                   aria-expanded="false"
                   >
                  <i class="fas fa-bell"></i>
                  <span class="badge rounded-pill badge-notification bg-danger"
                        >1</span
                    >
                </a>
                <ul
                    class="dropdown-menu dropdown-menu-end"
                    aria-labelledby="navbarDropdownMenuLink"
                    >
                  <li><a class="dropdown-item" href="#">Some news</a></li>
                  <li><a class="dropdown-item" href="#">Another news</a></li>
                  <li>
                    <a class="dropdown-item" href="#">Something else here</a>
                  </li>
                </ul>
              </li>
      
              <!-- Icon -->
      
              <!-- Avatar -->
              <li class="nav-item dropdown">
                <a
                   class="nav-link dropdown-toggle hidden-arrow d-flex align-items-center"
                   href="#"
                   id="navbarDropdownMenuLink"
                   role="button"
                   data-mdb-toggle="dropdown"
                   aria-expanded="false"
                   >
                  <img
                       src="https://mdbootstrap.com/img/Photos/Avatars/img (31).jpg"
                       class="rounded-circle"
                       height="22"
                       alt=""
                       loading="lazy"
                       />
                </a>
                <ul
                    class="dropdown-menu dropdown-menu-end"
                    aria-labelledby="navbarDropdownMenuLink"
                    >
                  <li><a class="dropdown-item" href="#">My profile</a></li>
                  <li><a class="dropdown-item" href="#">Settings</a></li>
                  <li><a class="dropdown-item" href="#">Logout</a></li>
                </ul>
              </li>
            </ul>
          </div>
          <!-- Container wrapper -->
        </nav>
        <!-- Navbar -->
      </header>
      <!--Main Navigation-->
      
      <!--Main layout-->
      <main style="margin-top: 58px">
        <div class="container pt-4">
      Tes
        </div>
      </main>

      <!--Main layout-->
</body>
</html>
