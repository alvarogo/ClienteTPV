@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1>Ejemplo cliente TPV</h1>
            <br>
            <p>Información y pasos a seguir: <a href="https://github.com/alvarogo/ClienteTPV/blob/master/README.md">Readme</a> o archivo README.md</p>
            <p>La página de pago es vuestra página para realizar el pago meidante el TPV.</p>
            <p>El código de ejemplo para la pantilla se encuentra en /resources/views/pago.</p>
            <p>El código de ejemplo para el controlador se encuentra en /Http/Controllers/TPVController.</p>
            <p>La petición a nuestra api se puede hacer por formulario POST o por AJAX, en la plantilla se encuentran ambos ejemplos.</p>
            <a  href="{{ url('/pago') }}">Página de pago</a>

        </div>
    </div>
</div>
@endsection
