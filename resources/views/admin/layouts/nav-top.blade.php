<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Navbar Search -->
    <!-- <li class="nav-item">
      <a class="nav-link" data-widget="navbar-search" href="#" role="button">
        <i class="fas fa-search"></i>
      </a>
      <div class="navbar-search-block">
        <form class="form-inline">
          <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-navbar" type="submit">
                <i class="fas fa-search"></i>
              </button>
              <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li> -->

    <li class="nav-item dropdown">
      <a class="nav-link" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="far fa-user"></i>
      </a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="{{route('show.profile')}}">
          <i class="far fa-user"></i> My Profile
        </a>
        <div class="dropdown-divider"></div>
        <a class="nav-link" href="{{route('show.changePassword')}}">
          <i class="fas fa-key"></i>  Change Password
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{route('logout')}}">
          <i class="far fa-arrow-alt-circle-right"></i>  Logout
        </a>
      </div>
    </li>
  </ul>
</nav>