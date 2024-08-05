@extends('layouts.default')

@section('page')
<h1 class="mb-4">Laporan Penjualan</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Produk</th>
                    <th>Kuantitas</th>
                    <th>Harga</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penjualans as $penjualan)
                    @foreach($penjualan->detailPenjualan as $detail)
                        <tr>
                            <td>{{ $penjualan->id_penjualan }}</td>
                            <td> {{ $detail->subProduk->produk->nama_produk }} {{ $detail->subProduk->produk->kategori->nama_kategori }} {{ $detail->subProduk->warna_produk }} {{ $detail->subProduk->size_produk }}</td>
                            <td>{{ $detail->jumlah_brg }}</td>
                            <td>{{ number_format($detail->harga_penjualan, 2) }}</td>
                            <td>{{ Carbon\Carbon::parse($penjualan->tgl_penjualan)->format('d F Y') }}</td>
                        </tr>
                    @endforeach
                @empty
                    <tr>
                        <td colspan="5">Data tidak tersedia</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop
