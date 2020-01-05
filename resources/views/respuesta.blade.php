@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Página para recibir la respuesta</h1>
            <br>
            <h4><strong>Código:</strong> {{$cod}}</h4>
            <h4><strong>Mensaje:</strong> {{$msg}}</h4>
            <h4><strong>Estado:</strong> {{$reason ?? ''}}</h4>

        </div>
    </div>
</div>
@endsection
