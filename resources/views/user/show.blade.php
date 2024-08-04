@extends('layouts.default')

@section('page')
<h1 class="mb-4">User Details</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Level:</strong> {{ ucfirst($user->level) }}</p>
        <a href="{{ route('user.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
</div>
@stop
