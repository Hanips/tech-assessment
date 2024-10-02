@extends('admin.index')
@section('content')
@if (Auth::user()->role == 'admin')
    <main>
        <div class="container-fluid px-4">
            <h4 class="mt-4">Manajemen User</h4>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}" class="text-decoration-none text-dark">Dashboard</a></li>
                <li class="breadcrumb-item active">Manajemen User</li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <a href="{{-- route('buku.create') --}}" class="btn btn-primary">Tambah</a>
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @php
                            $no = 1;
                            @endphp
                            @foreach($users as $user)
                            <tr>
                                <th>{{ $no }}</th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                                <td>{{ $user->status }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-info btn-sm me-1" href="{{-- route('buku.show', $buku->id) --}}" title="Detail">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a class="btn btn-warning btn-sm me-1" href="{{-- route('buku.edit', $buku->id) --}}" title="Ubah">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{-- route('buku.destroy', $buku->id) --}}" style="display: inline;">
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