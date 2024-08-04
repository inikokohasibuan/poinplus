@extends('layouts.default')

@section('page')
<h1 class="mb-4">Daftar Kategori</h1>
<!-- Tautan untuk menambah kategori -->
<a href="{{ route('master.kategori.create') }}" class="btn btn-primary mb-3">Tambah Kategori</a>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <!-- Tabel untuk menampilkan kategori -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategori as $item)
                <tr>
                    <td>{{ $item->nama_kategori }}</td>
                    <td>
                        <!-- Tautan untuk melihat, mengedit, dan menghapus kategori -->
                        <a href="{{ route('master.kategori.edit', $item->id_kategori) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('master.kategori.destroy', $item->id_kategori) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="text-center">Tidak ada data kategori</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop
