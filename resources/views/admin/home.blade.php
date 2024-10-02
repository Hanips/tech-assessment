@extends('admin.index')
@section('content')
@if (Auth::user()->role == 'admin')
    <main>
        <div class="container-fluid px-4">
            <h3 class="mt-4">Dashboard</h3>
            <br>
            <div class="row">
                <div class="col-md-3">
                    <div class="card mb-4 text-bg-light text-left">
                        <div class="card-body d-flex">
                            <div>
                                <p class="card-title">Jumlah User</p>
                                <h4 class="card-text d-flex align-items-center">
                                    {{ $usersCount }} <span class="ms-1"><small>User</small></span>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card mb-4 text-bg-light text-left">
                        <div class="card-body d-flex">
                            <div>
                                <p class="card-title">Jumlah User Aktif</p>
                                <h4 class="card-text d-flex align-items-center">
                                    {{ $activeUsersCount }} <span class="ms-1"><small>User</small></span>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card mb-4 text-bg-light text-left">
                        <div class="card-body d-flex">
                            <div>
                                <p class="card-title">Jumlah Produk</p>
                                <h4 class="card-text d-flex align-items-center">
                                    {{ $productsCount }} <span class="ms-1"><small>Product</small></span>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card mb-4 text-bg-light text-left">
                        <div class="card-body d-flex">
                            <div>
                                <p class="card-title">Jumlah Produk Aktif</p>
                                <h4 class="card-text d-flex align-items-center">
                                    {{ $activeProductsCount }} <span class="ms-1"><small>Product</small></span>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card mb-4">
                        <div class="card-header text-center">
                            Produk Terbaru
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between fw-bold">
                                        <div>Produk</div>
                                        <div class="text-center me-5">Tanggal Dibuat</div>
                                        <div class="text-end">Harga</div>
                                    </div>
                                </li>
                                @foreach ($latestProducts as $product)
                                    <li class="list-group-item d-flex align-items-center">
                                        @empty($product->photo)
                                            <div class="image-container">
                                                <img src="{{ url('img/noimg.png') }}" class="img-fluid" alt="Foto produk" style="object-fit: cover; width: 40px; height: 40px;">
                                            </div>
                                        @else
                                            @php
                                                $fotoPath = 'img/' . $product->photo;
                                                $fotoUrl = url($fotoPath);
                                            @endphp
                                            @if (file_exists(public_path($fotoPath)))
                                                <div class="image-container">
                                                    <img src="{{ $fotoUrl }}" class="img-fluid" alt="Foto produk" style="object-fit: cover; width: 40px; height: 40px;">
                                                </div>
                                            @else
                                                <div class="image-container">
                                                    <img src="{{ url('img/noimg.png') }}" class="img-fluid" alt="Foto produk" style="object-fit: cover; width: 40px; height: 40px;">
                                                </div>
                                            @endif
                                        @endempty
                                        <div class="ms-3 flex-grow-1">
                                            <strong>{{ $product->name }}</strong>
                                        </div>
                                        <div class="text-center me-5">{{ $product->created_at->format('d M Y') }}</div>
                                        <div class="text-end">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@else
    @include('admin.access_denied') 
@endif
@endsection
