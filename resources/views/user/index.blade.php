@extends('layouts.default')

@section('page')
<h1 class="mb-4">Daftar User</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <a href="{{ route('user.create') }}" class="btn btn-primary mb-3">Tambah User</a>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Level</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->level) }}</td>
                    <td>
                        <a href="{{ route('user.show', $user->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop
