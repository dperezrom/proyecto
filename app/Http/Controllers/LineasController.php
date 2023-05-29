<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use Illuminate\Http\Request;

class LineasController extends Controller
{
    // Ver Lineas
    public function ver_lineas(Factura $factura)
    {
        return view('admin.lineas.ver-lineas', [
            'factura' => $factura,
        ]);
    }
}
