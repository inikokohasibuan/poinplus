@extends('layouts.default')

@section('page')
<h1 class="mb-4">Daftar Barang Masuk</h1>
<a href="{{ route('rec_brg_masuk.create') }}" class="btn btn-primary mb-3">Tambah Barang Masuk</a>
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
                    <th>No Nota Garansi</th>
                    <th>Tanggal Barang Masuk</th>
                    <th>Lokasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recBrgMasuk as $item)
                <tr>
                    <td>{{ $item->no_nota_garansi }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tgl_brg_masuk)->translatedFormat('d F Y') }}</td>
                    <td>{{ $item->lokasi->nama_lokasi }}</td>
                    <td>
                        <a href="{{ route('rec_brg_masuk.show', $item->id_rec_brg_masuk) }}" class="btn btn-info btn-sm">Detail</a>
                        <a href="{{ route('rec_brg_masuk.edit', $item->id_rec_brg_masuk) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('rec_brg_masuk.destroy', $item->id_rec_brg_masuk) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus record ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data Barang Masuk</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop
