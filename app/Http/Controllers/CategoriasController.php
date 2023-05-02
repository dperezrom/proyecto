<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriasController extends Controller
{
    public function index()
    {
        $ordenes = ['nombre', 'descripcion'];
        $orden = request()->query('orden') ?: 'nombre';
        abort_unless(in_array($orden, $ordenes), 404);

        $torden = request()->query('torden') ?: 'ASC';

        $categorias = Categoria::orderBy($orden,$torden);

        if (($nombre = request()->query('nombre')) !== null) {
            $categorias->where('nombre', 'ilike', "%$nombre%");
        }

        if (($descripcion = request()->query('descripcion')) !== null) {
            $categorias->where('descripcion', 'ilike', "%$descripcion%");
        }

        $paginador = $categorias->paginate(2);

        $paginador->appends(compact(
            'nombre',
            'descripcion',
            'orden',
            'torden'
        ));

        return view('categorias.index', [
            'categorias' => $paginador
        ]);

    }
}
