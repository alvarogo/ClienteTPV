<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TPVController extends Controller
{
    public function paginaPago(Request $request)
    {
        return view("pago");
    }

    public function recibirRespuesta(Request $request)
    {
        // Lógica para recibir respuesta

        return view("respuesta")
            ->with('cod',$request->input('cod'))
            ->with('msg',$request->input('msg'))
            ->with('status',$request->input('status'));
    }
}
