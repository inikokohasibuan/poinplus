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
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
@stop
