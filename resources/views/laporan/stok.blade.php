@extends('layouts.default')

@section('page')
<h1 class="mb-4">Laporan Stok</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Lokasi</th>
                    <th>Kuantitas</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stoks as $stok)
                <tr>
                    <td>{{ $stok->subProduk->produk->nama_produk }} {{ $stok->subProduk->warna_produk }} {{ $stok->subProduk->size_produk }}</td>
                    <td>{{ $stok->lokasi->nama_lokasi }}</td>
                    <td>{{ $stok->jumlah_stok }} Lusin</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop
