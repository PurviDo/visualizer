<aside class="main-sidebar">
    <!-- Brand Logo -->
    <a href="{{route('dashboard')}}" class="brand-link">
      <img src="{{ asset('/assets/images/logo/logo.svg')}}" alt="CamClo3D" class="brand-image" style="opacity: .8">
      <!-- <span class="brand-text font-weight-light">CamClo3D</span> -->
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="adminlte/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div> -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <ul class="nav nav-treeview">
              <!-- <li class="nav-item">
                <a href="{{route('dashboard')}}" class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
              </li> -->
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
                <a href="{{route('sub-category.index')}}" class="nav-link {{ Route::is('sub-category.index') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-th"></i>
                  <p>
                    Sub Catgories
                  </p>
                </a>
              </li>              
              <li class="nav-item">
                <a href="{{route('packages.index')}}" class="nav-link {{ Route::is('packages.index') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-cube"></i>
                  <p>
                    Packages
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('inquiry.index')}}" class="nav-link {{ Route::is('inquiry.index') ? 'active' : '' }}">
                  <i class="nav-icon fas fa-cube"></i>
                  <p>
                    Inquiry
                  </p>
                </a>
              </li>
              <!-- <li class="nav-item">
                <a href="/template_mg" class="nav-link">
                  <i class="nav-icon fas fa-layer-group"></i>
                  <p>
                    Template Management
                  </p>
                </a>
              </li> -->
              <li class="nav-item {{ (Request::is('aboutUs') || Route::is('contact-us.index') || Request::is('privacyPolicy') || Request::is('termsConditions') || Route::is('faq-category.index') || Route::is('faq.index')) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-book"></i>
                  <p>
                    CMS Management
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>

                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{route('setting.index',['module' => 'aboutUs'])}}" class="nav-link {{ Request::is('aboutUs') ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>About Us</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('contact-us.index')}}" class="nav-link {{ Route::is('contact-us.index') ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Contact Us</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('setting.index',['module' => 'termsConditions'])}}" class="nav-link {{ Request::is('termsConditions')  ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Terms & Conditions</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('setting.index',['module' => 'privacyPolicy'])}}" class="nav-link {{ Request::is('privacyPolicy') ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Privacy Policy</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('faq-category.index')}}" class="nav-link {{ Route::is('faq-category.index') ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>FAQs Sections</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('faq.index')}}" class="nav-link {{ Route::is('faq.index') ? 'active' : '' }}">
                      <i class="far fa-circle nav-icon"></i>
                      <p>FAQs Question & Answers</p>
                    </a>
                  </li>
                </ul>
              </li>
              </li>
            </ul>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>