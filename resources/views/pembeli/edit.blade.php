@extends('layouts.default')

@section('page')
<h1 class="mb-4">Edit Pembeli</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('master.pembeli.update', $pembeli->id_pembeli) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nama_pembeli">Nama Pembeli</label>
                <input type="text" name="nama_pembeli" id="nama_pembeli" class="form-control" value="{{ $pembeli->nama_pembeli }}" required>
            </div>
            <div class="form-group">
                <label for="alamat_pembeli">Alamat</label>
                <textarea name="alamat_pembeli" id="alamat_pembeli" class="form-control" required>{{ $pembeli->alamat_pembeli }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@stop
