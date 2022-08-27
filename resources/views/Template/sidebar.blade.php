<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="javascript:void(0)" class="brand-link">
      <img src="{{asset('dist/img/Poltek.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">SIM Kemahasiswaan</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      @if (auth()->user()->level=="admin_mhs")
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="{{ route('dashboard_admin') }}" class="nav-link">
                <i class="nav-icon fas fa-home"></i>
                <p>Beranda</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.ormawa') }}" class="nav-link">
                <i class="nav-icon fas fa-building"></i>
                <p>Ormawa</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('admin.user') }}" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>User Management</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('list-pengajuan-admin') }}" class="nav-link">
                <i class="nav-icon fas fa-book"></i>
                <p>Pengajuan Proposal</p>
              </a>
            </li>
          </ul>
        </nav>
      @endif
      @if (auth()->user()->level=="bem")
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
              <a href="{{ route('dashboard_bem') }}" class="nav-link">
                <i class="nav-icon fas fa-home"></i>
                <p>Beranda</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('list-pengajuan-bem') }}" class="nav-link">
                <i class="nav-icon fas fa-book"></i>
                <p>Pengajuan Proposal</p>
              </a>
            </li>
          </ul>
        </nav>
      @endif
      @if (auth()->user()->level=="ormawa")
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
            with font-awesome or any other icon font library -->

            <li class="nav-item">
              <a href="{{ route('dashboard_ormawa') }}" class="nav-link">
                <i class="nav-icon fas fa-home"></i>
                <p>Beranda</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('list-pengajuan-ormawa') }}" class="nav-link">
                <i class="nav-icon fas fa-book"></i>
                <p>Pengajuan Proposal</p>
              </a>
            </li>
          </ul>
        </nav>
      @endif
    </div>
    <!-- /.sidebar -->
</aside>