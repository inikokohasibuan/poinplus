@extends('layouts.default')

@section('page')
<h1 class="mb-4">Daftar Lokasi</h1>
<a href="{{ route('master.lokasi.create') }}" class="btn btn-primary mb-3">Tambah Lokasi</a>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Lokasi</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lokasi as $item)
                <tr>
                    <td>{{ $item->nama_lokasi }}</td>
                    <td>{{ $item->alamat_lokasi }}</td>
                    <td>
                        <a href="{{ route('master.lokasi.edit', $item->id_lokasi) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('master.lokasi.destroy', $item->id_lokasi) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus lokasi ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center">Tidak ada data lokasi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop
