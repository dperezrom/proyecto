<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LineasController extends Controller
{
    // Ver Lineas
    public function ver_lineas(Factura $factura)
    {
        return view('admin.lineas.ver-lineas', [
            'factura' => $factura,
        ]);
    }

    // Ver detalle factura modo usuario
    public function ver_detalle(Factura $factura)
    {
      if(Auth::id() != $factura->user_id) {
          abort(404);
      }
        return view('lineas.ver-detalle', [
            'factura' => $factura,
        ]);
    }
}
