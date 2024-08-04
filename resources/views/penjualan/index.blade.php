@extends('layouts.default')

@section('page')
<h1 class="mb-4">Daftar Penjualan</h1>
<a href="{{ route('penjualan.create') }}" class="btn btn-primary mb-3">Tambah Penjualan</a>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Lokasi</th>
                    <th>Pembeli</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penjualan as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ Carbon\Carbon::parse($item->tgl_penjualan)->format('d F Y') }}</td>
                    <td>{{ $item->lokasi->nama_lokasi }}</td>
                    <td>{{ $item->pembeli ? $item->pembeli->nama_pembeli : 'N/A' }}</td>
                    <td>
                        <a href="{{ route('penjualan.show', $item->id_penjualan) }}" class="btn btn-info btn-sm">Lihat</a>
                        <a href="{{ route('penjualan.edit', $item->id_penjualan) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('penjualan.destroy', $item->id_penjualan) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus penjualan ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data penjualan</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop
