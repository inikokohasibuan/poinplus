@extends('layouts.default')

@section('page')
<h1 class="mb-4">Daftar Pemindahan Stok</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <a href="{{ route('pemindahan_stok.create') }}" class="btn btn-primary mb-3">Pemindahan Stok</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sub Produk</th>
                    <th>Lokasi Asal</th>
                    <th>Lokasi Tujuan</th>
                    <th>Jumlah Pindah</th>
                    <th>Waktu Pindah</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pemindahanStok as $pindah)
                <tr>
                    <td>{{ $pindah->subProduk->produk->nama_produk }} {{ $pindah->subProduk->warna_produk }} {{ $pindah->subProduk->size_produk }}</td>
                    <td>{{ $pindah->lokasiAsal->nama_lokasi }}</td>
                    <td>{{ $pindah->lokasiTujuan->nama_lokasi }}</td>
                    <td>{{ $pindah->jumlah_pindah }}</td>
                    <td>{{ Carbon\Carbon::parse($pindah->waktu_pindah)->format('d F Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data pemindahan stok</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop
