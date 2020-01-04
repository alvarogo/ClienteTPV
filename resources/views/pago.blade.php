@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form id="paymentForm" action="http://localhost:8000/api/sendPayment" method="post">
                <div class="form-group">
                  <label for="user">User</label>
                  <input type="text" class="form-control" id="user" name="user"  aria-describedby="emailHelp" placeholder="User" value="alvaro@alu.ua.es">
                </div>
                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="text" class="form-control" id="password" name="password" placeholder="Password" value="123456">
                </div>
                <div class="form-group">
                  <label for="quantity">Quantity</label>
                  <input type="number" class="form-control" id="quantity" name="quantity" step="0.01" value="2.05">
                </div>
                <div class="form-group">
                  <label for="concept">Concept</label>
                  <input type="text" class="form-control" id="concept" name="concept" placeholder="Concept" value="Pago 79033492">
                </div>
                <div class="form-group">
                  <label for="urlRedirect">urlRedirect</label>
                  <input type="text" class="form-control" id="urlRedirect" name="urlRedirect" placeholder="URL" value="http://localhost:8001/respuesta">
                </div>
                <button  type="submit" class="btn btn-primary">Enviar desde formulario</button>
                <button  type="button" id="paymentButton" class="btn btn-primary">Enviar desde AJAX</button>
              </form>
            </div>
        </div>
    </div>
</div>

<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
<script type='text/javascript'>

    $(document).ready(function(){
        const URL = 'http://localhost:8000/api/sendPayment';

        $('#paymentButton').click(function(){

            // Los datos se cogen del formulario en el ejemplo pero no
            // es necesario tener un formulario si se envía usando AJAX.
            var obj = {
                user : $('#user').val(),
                password : $('#password').val(),
                quantity : $('#quantity').val(),
                concept : $('#concept').val(),
                urlRedirect : $('#urlRedirect').val() }
            ;

            $.post(URL, obj, function(data, status){
              var openWindow = window.open('', '_self');
              openWindow.document.write(data);
              openWindow.document.close();
            })
        })
    })

  </script>
@endsection
