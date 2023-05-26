<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ValoracionesController extends Controller
{

    // Ver valoraciones
    public function ver_valoraciones(Producto $producto)
    {
        // Orden por fecha de creación
        $orden = request()->query('orden') ?: 'desc';
        abort_unless(in_array($orden, ['asc', 'desc']), 404);

        $valoraciones = $producto->valoraciones()->orderBy('created_at', $orden);
        $paginador = $valoraciones->paginate(2);
        $paginador->appends(compact(
            'orden',
        ));

        return view('admin.valoraciones.ver-valoraciones', [
            'producto' => $producto,
            'paginador' => $paginador,
        ]);
    }
}
