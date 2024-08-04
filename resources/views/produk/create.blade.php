@extends('layouts.default')

@section('page')
<h1 class="mb-4">Tambah Produk</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <!-- Formulir untuk menambah produk -->
        <form action="{{ route('master.produk.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="kategori_produk">Kategori Produk</label>
                <select name="kategori_produk" id="kategori_produk" class="form-control" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($kategori as $kat)
                        <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                    @endforeach
                </select>
                @error('kategori_produk')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="nama_produk">Nama Produk</label>
                <input type="text" name="nama_produk" id="nama_produk" class="form-control" value="{{ old('nama_produk') }}" required>
                @error('nama_produk')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('master.produk.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@stop
