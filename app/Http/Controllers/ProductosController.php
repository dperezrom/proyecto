<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    // Index
    public function index()
    {
        $productos = Producto::orderBy('denominacion', 'asc');
        $paginador = $productos->paginate(10);

        return view('productos.index', [
            'productos' => $paginador
        ]);

    }

}
