@extends('layouts.default')

@section('page')
<h1 class="mb-4">Tambah User</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('user.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password (min 8 karakter)</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="level">Level</label>
                <select name="level" id="level" class="form-control" required>
                    <option value="admin">Admin</option>
                    <option value="owner">Owner</option>
                    <option value="penjaga_toko">Penjaga Toko</option>
                </select>
            </div>

            <!-- Pilihan Lokasi (tersembunyi secara default) -->
            <div class="form-group" id="lokasi-container" style="display:none;">
                <label for="id_lokasi">Pilih Lokasi</label>
                <select name="id_lokasi" id="id_lokasi" class="form-control">
                    @foreach($lokasi as $lok) <!-- Asumsikan $lokasis dioper ke view -->
                    <option value="{{ $lok->id_lokasi }}">{{ $lok->nama_lokasi }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

<script>
    document.getElementById('level').addEventListener('change', function () {
        var level = this.value;
        var lokasiContainer = document.getElementById('lokasi-container');

        if (level === 'penjaga_toko') {
            lokasiContainer.style.display = 'block'; // Tampilkan pilihan lokasi
        } else {
            lokasiContainer.style.display = 'none'; // Sembunyikan pilihan lokasi
        }
    });
</script>
@stop