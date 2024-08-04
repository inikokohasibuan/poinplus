@extends('layouts.default')

@section('page')
Dashboard
@stop

@section('content')
<!-- <button class="btn btn-digigreen">tes
    <div class="konten">
        <h2>Tutorial</h2>
        <p>consectetur adipisicing elit. Sunt repellat enim porro cum maxime? Velit aut tempora error, suscipit nisi necessitatibus ullam nemo eos cum quos? At vero expedita doloribus.</p>
    </div>
</button> -->
{{session()->flush();}}
@stop