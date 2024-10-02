@extends('admin.index')
@section('content')
@if (Auth::user()->role == 'admin')
    <main>
        <div class="container-fluid px-4">
            <h4 class="mt-4">Manajemen Produk</h4>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}" class="text-decoration-none text-dark">Dashboard</a></li>
                <li class="breadcrumb-item active">Manajemen Produk</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Tambah</a>
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Foto</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Foto</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @php
                            $no = 1;
                            @endphp
                            @foreach($products as $product)
                            <tr>
                                <th>{{ $no }}</th>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->price }}</td>
                                <td>
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
                                </td>
                                <td>
                                    @if ($product->status == 'active')
                                        <div style="display: inline-block; padding: 0.25em 0.4em; font-size: 75%; font-weight: 700; color: #fff; background-color: #28a745; border-radius: 0.2rem;">Aktif</div>
                                    @else
                                        <div style="display: inline-block; padding: 0.25em 0.4em; font-size: 75%; font-weight: 700; color: #212529; background-color: #ff0707; border-radius: 0.2rem;">Non Aktif</div>
                                    @endif
                                </td>
                                
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-info btn-sm me-1" href="{{ route('admin.products.show', $product->id) }}" title="Detail">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a class="btn btn-warning btn-sm me-1" href="{{ route('admin.products.edit', $product->id) }}" title="Ubah">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.products.destroy', $product->id) }}" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" type="submit" title="Hapus" name="proses" value="hapus" onclick="return confirm('Anda Yakin Data Dihapus?')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            <input type="hidden" name="idx" value=""/>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @php $no++ @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@else
    @include('admin.access_denied')
@endif
@endsection