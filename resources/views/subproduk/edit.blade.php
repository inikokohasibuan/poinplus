<!-- resources/views/subproduk/edit.blade.php -->
@extends('layouts.default')

@section('page')
<h1 class="mb-4">Edit Sub Produk</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('master.subproduk.update', $subproduk->id_sub_produk) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="id_produk">Produk</label>
                <select name="id_produk" id="id_produk" class="form-control" required>
                    @foreach($produk as $item)
                        <option value="{{ $item->id_produk }}" {{ $subproduk->id_produk == $item->id_produk ? 'selected' : '' }}>
                            {{ $item->nama_produk }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="warna_produk">Warna</label>
                <input type="text" name="warna_produk" id="warna_produk" class="form-control" value="{{ $subproduk->warna_produk }}" required>
            </div>
            <div class="form-group">
                <label for="size_produk">Size</label>
                <input type="text" name="size_produk" id="size_produk" class="form-control" value="{{ $subproduk->size_produk }}" required>
            </div>
            <div class="form-group">
                <label for="harga_produk">Harga</label>
                <input type="number" name="harga_produk" id="harga_produk" class="form-control" value="{{ $subproduk->harga_produk }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@stop
           
