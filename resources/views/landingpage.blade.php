<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Styling tambahan */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            border-bottom: 1px solid #ddd;
        }
        .header .logo {
            font-size: 24px;
            font-weight: bold;
        }
        .header .search-bar {
            width: 50%;
        }
        .carousel-control {
            background-color: rgba(255, 255, 255, 0.7); /* Transparan */
        }
        .latest-products {
            margin-top: 20px;
        }
        .product-card {
            flex: 0 0 20%;
            margin-right: 10px;
            transition: box-shadow 0.3s; /* Transisi untuk shadow */
        }
        .product-card:hover {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3); /* Efek shadow saat hover */
        }
        .product-carousel {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .carousel-navigation {
            position: absolute;
            bottom: -30px;
            left: 10px;
        }
        /* Styling untuk footer */
        .footer {
            background-color: #f8f9fa;
            padding: 20px 20px;
            margin-top: 40px;
            border-top: 2px solid #ddd; /* Garis atas footer */
        }
        .footer .footer-logo {
            width: 100px; /* Atur lebar logo */
        }
        .footer .social-icons a {
            margin: 0 10px;
            color: #007bff; /* Ganti dengan warna yang diinginkan */
        }
        .footer .footer-section {
            flex: 1; /* Membagi ruang secara merata */
        }
        .footer .footer-links {
            margin: 20px 0;
        }
    </style>
</head>
<body>

    <!-- Header Section -->
    <header class="header">
        <img src="{{ asset('img/logo-vascomm.png') }}" style="height: 20px; width: auto;" alt="">
        <div class="search-bar">
            <input type="text" class="form-control" style="background-color: #f4f4f4; border-radius: 5px;" placeholder="Cari parfum kesukaanmu">
        </div>
        <div class="auth-buttons">
            @guest
                <a href="{{ url('/login') }}" class="btn btn-light" style="border-color:dodgerblue;">MASUK</a>
                <a href="{{ url('/register') }}" class="btn btn-primary">DAFTAR</a>
            @else
                <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="ms-auto text-end">
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
                            @if (Auth::user()->role == 'admin')
                                <li><a class="dropdown-item" href="{{ url('/admin/dashboard') }}">Adminpage</a></li>
                                <li><hr class="dropdown-divider"/></li>
                            @endif
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </ul>
                    </li>
                </ul>
            @endguest
            
        </div>
    </header>

    <!-- Hero Section with Carousel -->
    <section class="hero my-3">
        <div id="carouselExample" class="carousel slide mx-auto col-9" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="https://via.placeholder.com/800x300" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="https://via.placeholder.com/800x300" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="https://via.placeholder.com/800x300" class="d-block w-100" alt="...">
                </div>
            </div>
            <div class="carousel-navigation">
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>

    <!-- Terbaru Section -->
    <section class="latest-products my-5">
        <h2>Terbaru</h2>
        <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($products->chunk(5) as $chunkIndex => $productChunk)
                    <div class="carousel-item {{ $chunkIndex == 0 ? 'active' : '' }}">
                        <div class="d-flex justify-content-center">
                            @foreach ($productChunk as $product)
                                <div class="card product-card mx-2" style="width: 15rem;">
                                    @empty($product->photo)
                                        <div class="image-container">
                                            <img src="{{ url('img/noimg.png') }}" class="img-fluid" alt="Foto produk" style="object-fit: cover; width: 100%; height: 200px;">
                                        </div>
                                    @else
                                        @php
                                            $fotoPath = 'img/' . $product->photo;
                                            $fotoUrl = url($fotoPath);
                                        @endphp
                                        @if (file_exists(public_path($fotoPath)))
                                            <div class="image-container">
                                                <img src="{{ $fotoUrl }}" class="img-fluid" alt="Foto produk" style="object-fit: cover; width: 100%; height: 200px;">
                                            </div>
                                        @else
                                            <div class="image-container">
                                                <img src="{{ url('img/noimg.png') }}" class="img-fluid" alt="Foto produk" style="object-fit: cover; width: 100%; height: 200px;">
                                            </div>
                                        @endif
                                    @endempty
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $product->name }}</h5>
                                        <p class="card-text">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev" style="width: 5%;">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next" style="width: 5%;">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>
    
    

    <!-- Footer Section -->
    <footer class="footer d-flex">
        <div class="footer-section d-flex flex-column align-items-start">
            <img src="{{ asset('img/logo-vascomm.png') }}" class="footer-logo" alt="Logo Vascomm">
            <div class="social-icons mt-2">
                <a href="#"><img src="https://via.placeholder.com/30" alt="Facebook"></a>
                <a href="#"><img src="https://via.placeholder.com/30" alt="Twitter"></a>
                <a href="#"><img src="https://via.placeholder.com/30" alt="Instagram"></a>
            </div>
        </div>
        <div class="footer-section">
            <h5>Layanan</h5>
            <a href="#">Layanan 1</a> | 
            <a href="#">Layanan 2</a> | 
            <a href="#">Layanan 3</a>
        </div>
        <div class="footer-section">
            <h5>Tentang Kami</h5>
            <a href="#">Tentang Vascomm</a>
        </div>
        <div class="footer-section">
            <h5>Mitra</h5>
            <a href="#">Mitra 1</a> | 
            <a href="#">Mitra 2</a>
        </div>
        <div class="footer-section">
            <!-- Bagian ini kosong -->
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
