@extends('layouts.default')

@section('page')
<h1 class="mb-4">Daftar Produk</h1>
<!-- Tautan untuk menambah produk -->
<a href="{{ route('master.produk.create') }}" class="btn btn-primary mb-3">Tambah Produk</a>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <!-- Tabel untuk menampilkan produk -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Kategori Produk</th>
                    <th>Nama Produk</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($produk as $item)
                <tr>
                    <td>{{ $item->kategori->nama_kategori ?? 'Kategori Tidak Diketahui' }}</td>
                    <td>{{ $item->nama_produk }}</td>
                    <td>
                        <!-- Tautan untuk melihat, mengedit, dan menghapus produk -->
                        <a href="{{ route('master.produk.edit', $item->id_produk) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('master.produk.destroy', $item->id_produk) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center">Tidak ada data produk</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop
