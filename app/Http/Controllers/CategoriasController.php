<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriasController extends Controller
{
    public function index()
    {

        $categorias = Categoria::orderBy('nombre');

        $paginador = $categorias->paginate(2);

        return view('categorias.index', [
            'categorias' => $paginador,
        ]);

    }
}
