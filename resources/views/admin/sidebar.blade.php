@if (Auth::user()->role == 'admin')
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="{{ url('/admin/dashboard') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                        Dashboard
                    </a>
                    <a class="nav-link {{ request()->is('admin/users') ? 'active' : '' }}" href="{{ url('/admin/users') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-user-alt"></i></div>
                        Manajemen User
                    </a>
                    <a class="nav-link {{ request()->is('admin/products') ? 'active' : '' }}" href="{{ url('/admin/products') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-archive"></i></div>
                        Manajemen Produk
                    </a>
                </div>
            </div>
        </nav>
    </div>
@endif