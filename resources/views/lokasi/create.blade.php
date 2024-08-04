@extends('layouts.default')

@section('page')
<h1 class="mb-4">Tambah Lokasi</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('master.lokasi.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama_lokasi">Nama Lokasi</label>
                <input type="text" name="nama_lokasi" id="nama_lokasi" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="alamat_lokasi">Alamat</label>
                <textarea name="alamat_lokasi" id="alamat_lokasi" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@stop
