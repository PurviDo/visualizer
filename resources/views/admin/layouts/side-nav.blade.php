<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ asset('/assets/images/logo/logo.png')}}" alt="Visualizer" class="brand-image" style="opacity: .8">
      <span class="brand-text font-weight-light">Visualizer</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="adminlte/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('dashboard.index')}}" class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('customers.index')}}" class="nav-link {{ Route::is('customers') ? 'active' : '' }}">
                <a href="/customers" class="nav-link">
                  <i class="nav-icon fas fa-users"></i>
                  <p>
                    Users
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('category.index')}}" class="nav-link {{ Route::is('category.index') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-th"></i>
                  <p>
                    Catgories
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/sub_catgories" class="nav-link">
                  <i class="nav-icon fas fa-th"></i>
                  <p>
                    Sub Catgories
                  </p>
                </a>
              </li>              
              <li class="nav-item">
                <a href="/packages" class="nav-link">
                  <i class="nav-icon fas fa-cube"></i>
                  <p>
                    Packages
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/template_mg" class="nav-link">
                  <i class="nav-icon fas fa-layer-group"></i>
                  <p>
                    Template Management
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/cms_mg" class="nav-link">
                  <i class="nav-icon fas fa-book"></i>
                  <p>
                    CMS Management
                  </p>
                </a>
              </li>
            </ul>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>