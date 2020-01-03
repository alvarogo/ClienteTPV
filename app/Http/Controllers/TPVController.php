<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TPVController extends Controller
{
    public function enviarPago(Request $request)
    {

    }

    public function paginaPago(Request $request)
    {
        return view("pago");
    }
}
