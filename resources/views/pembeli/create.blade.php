@extends('layouts.default')

@section('page')
<h1 class="mb-4">Tambah Pembeli</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('master.pembeli.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama_pembeli">Nama Pembeli</label>
                <input type="text" name="nama_pembeli" id="nama_pembeli" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="alamat_pembeli">Alamat</label>
                <textarea name="alamat_pembeli" id="alamat_pembeli" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@stop
