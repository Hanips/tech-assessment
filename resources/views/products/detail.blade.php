@extends('admin.index')
@section('content')

@if (Auth::user()->role == 'admin')
  <main>
    <br><br>
    <div class="container-fluid px-4 mx-auto">
      <div class="container">
        <h2 style="margin-left: 50px;">Detail Produk</h2>
        <div class="row justify-content-center">
          <div class="col-md-11"><br>
            <div class="card rounded">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    @empty($product->photo)
                      <img src="{{ url('img/nophoto.jpg') }}" class="img-fluid" alt="Foto Produk">
                    @else
                      @php
                        $photoPath = 'img/' . $product->photo;
                        $photoUrl = url($photoPath);
                      @endphp
                      @if (file_exists(public_path($photoPath)))
                        <img src="{{ $photoUrl }}" class="img-fluid" alt="Foto Produk">
                      @else
                        <img src="{{ url('img/nophoto.jpg') }}" class="img-fluid" alt="Foto Produk">
                      @endif
                    @endempty
                  </div>
                  <div class="col-md-6 d-flex align-items-center">
                    <div>
                      <h2>{{ $product->name }}</h2>
                      <p>Harga: Rp. {{ number_format($product->price, 0, ',', '.') }}</p>
                      <p>Status: {{ $product->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}</p>
                      
                      <a href="{{ url('/admin/products') }}" class="btn btn-primary">Kembali</a>
                      <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning">Ubah</a>
                    </div>
                  </div>
                </div>
              </div>
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
