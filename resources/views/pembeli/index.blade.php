@extends('layouts.default')

@section('page')
<h1 class="mb-4">Daftar Pembeli</h1>
<a href="{{ route('master.pembeli.create') }}" class="btn btn-primary mb-3">Tambah Pembeli</a>
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
                    <th>Nama Pembeli</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pembeli as $item)
                <tr>
                    <td>{{ $item->nama_pembeli }}</td>
                    <td>{{ $item->alamat_pembeli }}</td>
                    <td>
                        <a href="{{ route('master.pembeli.edit', $item->id_pembeli) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('master.pembeli.destroy', $item->id_pembeli) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pembeli ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center">Tidak ada data pembeli</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop
