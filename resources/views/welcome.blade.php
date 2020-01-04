@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Ejemplo cliente TPV</h1>
            <a class="nav-link" href="{{ url('/pago') }}">Página de pago</a>

        </div>
    </div>
</div>
@endsection
