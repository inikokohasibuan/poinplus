@extends('layouts.default')

@section('page')
<h1 class="mb-4">Edit User</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('user.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="form-group">
                <label for="password">Password (Kosongkan jika tidak ingin mengubah)</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>
            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
            </div>
            <div class="form-group">
                <label for="level">Level</label>
                <select name="level" id="level" class="form-control" required>
                    <option value="admin" {{ old('level', $user->level) == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="owner" {{ old('level', $user->level) == 'owner' ? 'selected' : '' }}>Owner</option>
                    <option value="penjaga_toko" {{ old('level', $user->level) == 'penjaga_toko' ? 'selected' : '' }}>Penjaga Toko</option>
                </select>
            </div>

            <!-- Pilihan Lokasi (akan ditampilkan jika level = penjaga_toko) -->
            <div class="form-group" id="lokasi-container" style="display: {{ old('level', $user->level) == 'penjaga_toko' ? 'block' : 'none' }};">
                <label for="id_lokasi">Pilih Lokasi</label>
                <select name="id_lokasi" id="id_lokasi" class="form-control">
                    @foreach($lokasi as $lok) <!-- Asumsikan $lokasis dioper ke view -->
                    <option value="{{ $lok->id_lokasi }}" {{ old('id_lokasi', $user->id_lokasi) == $lok->id_lokasi ? 'selected' : '' }}>
                        {{ $lok->nama_lokasi }}
                    </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>

        <script>
            document.getElementById('level').addEventListener('change', function() {
                var level = this.value;
                var lokasiContainer = document.getElementById('lokasi-container');

                if (level === 'penjaga_toko') {
                    lokasiContainer.style.display = 'block'; // Tampilkan pilihan lokasi
                } else {
                    lokasiContainer.style.display = 'none'; // Sembunyikan pilihan lokasi
                }
            });
        </script>

    </div>
</div>
@stop