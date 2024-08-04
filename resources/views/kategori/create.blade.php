@extends('layouts.default')

@section('page')
<h1 class="mb-4">Tambah Kategori</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <!-- Formulir untuk menambah kategori -->
        <form action="{{ route('master.kategori.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama_kategori">Nama Kategori</label>
                <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" value="{{ old('nama_kategori') }}" required>
                @error('nama_kategori')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('master.kategori.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@stop
