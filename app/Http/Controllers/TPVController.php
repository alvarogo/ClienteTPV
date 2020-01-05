<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TPVController extends Controller
{
    // Vuestra página donde se encuentra la acción de pagar
    public function paginaPago(Request $request)
    {
        return view("pago");
    }

    // Tenéis que crear un endpoint GET para recibir la respuesta de la api
    // Ej. Route::get('/respuesta', 'TPVController@recibirRespuesta')->name('respuesta');
    public function recibirRespuesta(Request $request)
    {
        $cod = $request->input('cod');
        $msg = $request->input('msg');
        $reason = $request->input('reason');

        // Lógica de vuestra aplicación para tratar la respuesta

        return view("respuesta")
            ->with('cod', $cod)
            ->with('msg', $msg)
            ->with('reason', $reason);
    }
}
