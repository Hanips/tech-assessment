@extends('admin.index')
@section('content')

@if (Auth::user()->role == 'admin')
    <main>
        <div class="container-fluid px-4">
            <div class="container px-5 my-5">
                <h2>Form Update Produk</h2>
                <form method="POST" action="{{ route('admin.products.update', $product->id) }}" id="contactForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-floating mb-3">
                        <input class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $product->name) }}" id="name" type="text" placeholder="Nama Produk" />
                        <label for="name">Nama Produk</label>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price', $product->price) }}" id="price" type="number" placeholder="Harga" />
                        <label for="price">Harga</label>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <select class="form-select @error('status') is-invalid @enderror" name="status" aria-label="status">
                            <option value="">-- Pilih Status --</option>
                            @foreach ($ar_status as $key => $label)
                                @php $sel = (old('status', $product->status) == $key) ? 'selected' : ''; @endphp
                                <option value="{{ $key }}" {{ $sel }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        <label for="status">Status</label>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input class="form-control @error('photo') is-invalid @enderror" name="photo" id="photo" type="file" placeholder="Gambar" />
                        <label for="photo">Gambar</label>
                        @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button class="btn btn-primary" name="proses" value="simpan" id="simpan" type="submit">Simpan</button>
                    <a href="{{ url('/admin/products') }}" class="btn btn-danger">Batal</a>
                </form>
            </div>
        </div>
    </main>
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
@else
    @include('admin.access_denied')
@endif
@endsection
