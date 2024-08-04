@extends('layouts.default')

@section('page')
<h1 class="mb-4">Detail Penjualan</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <p><strong>Tanggal Penjualan:</strong> {{ Carbon\Carbon::parse($penjualan->tgl_penjualan)->format('d F Y') }}</p>
        <p><strong>Lokasi:</strong> {{ $penjualan->lokasi->nama_lokasi }}</p>
        <p><strong>Pembeli:</strong> {{ $penjualan->pembeli ? $penjualan->pembeli->nama_pembeli : 'N/A' }}</p>
        
        <h4>Detail Barang</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sub Produk</th>
                    <th>Harga Pembelian</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penjualan->detailPenjualan as $detail)
                <tr>
                    <td>{{ $detail->subProduk->produk->nama_produk }} {{ $detail->subProduk->produk->kategori->nama_kategori }} {{ $detail->subProduk->warna_produk }} {{ $detail->subProduk->size_produk }}</td>
                    <td>Rp{{ number_format($detail->harga_penjualan, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@stop
