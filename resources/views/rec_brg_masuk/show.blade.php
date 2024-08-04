@extends('layouts.default')

@section('page')
<h1 class="mb-4">Detail Barang Masuk</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>No Nota Garansi</th>
                <td>{{ $recBrgMasuk->no_nota_garansi }}</td>
            </tr>
            <tr>
                <th>Tanggal Barang Masuk</th>
                <td>{{ \Carbon\Carbon::parse($recBrgMasuk->tgl_brg_masuk)->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <th>Lokasi</th>
                <td>{{ $recBrgMasuk->lokasi->nama_lokasi }}</td>
            </tr>
        </table>
        <h3>Detail Barang Masuk</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sub Produk</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recBrgMasuk->detailBrgMasuk as $detail)
                <tr>
                    <td>{{ $detail->subProduk->produk->nama_produk }} {{ $detail->subProduk->produk->kategori->nama_kategori }} {{ $detail->subProduk->warna_produk }} {{ $detail->subProduk->size_produk }}</td>
                    <td>{{ $detail->jumlah_brg_masuk }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('rec_brg_masuk.index') }}" class="btn btn-primary">Kembali</a>
    </div>
</div>
@stop
