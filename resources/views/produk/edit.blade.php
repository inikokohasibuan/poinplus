@extends('layouts.default')

@section('page')
<h1 class="mb-4">Edit Produk</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <!-- Formulir untuk mengedit produk -->
        <form action="{{ route('master.produk.update', $produk->id_produk) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="kategori_produk">Kategori Produk</label>
                <select name="kategori_produk" id="kategori_produk" class="form-control" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($kategori as $kat)
                        <option value="{{ $kat->id_kategori }}" {{ $kat->id_kategori == $produk->kategori_produk ? 'selected' : '' }}>
                            {{ $kat->nama_kategori }}
                        </option>
                    @endforeach
                </select>
                @error('kategori_produk')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="nama_produk">Nama Produk</label>
                <input type="text" name="nama_produk" id="nama_produk" class="form-control" value="{{ old('nama_produk', $produk->nama_produk) }}" required>
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
