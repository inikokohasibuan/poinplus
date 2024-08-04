@extends('layouts.default')

@section('page')
<h1 class="mb-4">Pemindahan Stok</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('pemindahan_stok.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="id_sub_produk">Sub Produk</label>
                <select name="id_sub_produk" id="id_sub_produk" class="form-control" required>
                    <option value="">Pilih Sub Produk</option>
                    @foreach($subProduk as $item)
                        <option value="{{ $item->id_sub_produk }}">{{ $item->produk->nama_produk }} {{ $item->warna_produk }} {{ $item->size_produk }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="id_lokasi_asal">Lokasi Asal</label>
                <select name="id_lokasi_asal" id="id_lokasi_asal" class="form-control" required>
                    <option value="">Pilih Lokasi Asal</option>
                    @foreach($lokasi as $item)
                        <option value="{{ $item->id_lokasi }}">{{ $item->nama_lokasi }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="id_lokasi_tujuan">Lokasi Tujuan</label>
                <select name="id_lokasi_tujuan" id="id_lokasi_tujuan" class="form-control" required>
                    <option value="">Pilih Lokasi Tujuan</option>
                    @foreach($lokasi as $item)
                        <option value="{{ $item->id_lokasi }}">{{ $item->nama_lokasi }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="jumlah_pindah">Jumlah Pindah</label>
                <input type="number" name="jumlah_pindah" id="jumlah_pindah" class="form-control" required min="1">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@stop
