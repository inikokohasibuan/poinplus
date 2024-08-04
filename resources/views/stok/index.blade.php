@extends('layouts.default')

@section('page')
<h1 class="mb-4">Stok Tersedia</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sub Produk</th>
                    <th>Lokasi</th>
                    <th>Jumlah Stok</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stokLokasi as $stok)
                <tr>
                    <td>{{ $stok->subProduk->produk->nama_produk }} {{ $stok->subProduk->produk->kategori->nama_kategori }} {{ $stok->subProduk->warna_produk }} {{ $stok->subProduk->size_produk }}</td>
                    <td>{{ $stok->lokasi->nama_lokasi }}</td>
                    <td>{{ $stok->jumlah_stok }} Lusin</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center">Tidak ada data stok</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop
