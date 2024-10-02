@if (Auth::user()->role == 'admin')
    <nav class="sb-topnav navbar navbar-expand navbar-light bg-light">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="{{ url('/admin/dashboard') }}"><img src="{{ asset('img/logo-vascomm.png') }}" style="height: 20px; width: auto;" alt=""></a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="ms-auto text-end">
                        <p class="text-primary mb-0" style="font-size: 0.6rem;">Halo Admin,</p>
                        <p class="mb-0">{{ Auth::user()->name }}</p>
                    </div>
                    @empty(Auth::user()->foto)
                        <img src="{{ asset('img/noimg.png') }}" alt="avatar" class="rounded-circle img-fluid" style="width: 30px; height: 30px;">
                    @else
                        @php
                            $fotoPath = 'img/' . Auth::user()->foto;
                            $fotoUrl = url($fotoPath);
                        @endphp
                        @if (file_exists(public_path($fotoPath)))
                            <img src="{{ $fotoUrl }}" class="rounded-circle img-fluid" style="width: 30px; height: 30px;">
                        @else
                            <img src="{{ asset('img/noimg.png') }}" class="rounded-circle img-fluid" style="width: 30px; height: 30px;">
                        @endif
                    @endempty
                </a>
                
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="{{ url('/') }}">Landingpage</a></li>
                    <li><hr class="dropdown-divider"/></li>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </ul>
            </li>
        </ul>
    </nav>
@endif