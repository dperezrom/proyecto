<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    // Index
    public function index()
    {
        // Campos buscador
        $campos = [
            'denominacion',
            'descripcion',
            'categoria_id',
            'activo',
            'precio',
            'precio_signo',
            'iva',
            'stock',
            'stock_signo',
            'descuento',
            'descuento_signo',
        ];

        foreach ($campos as $campo) {
            ${$campo} = request()->query($campo);
        }

        // Orden
        $ordenes = ['denominacion', 'descripcion', 'precio', 'categoria_id'];
        $orden = request()->query('orden') ?: 'denominacion';
        abort_unless(in_array($orden, $ordenes), 404);
        $torden = request()->query('torden') ?: 'ASC';

        $productos = Producto::orderBy($orden, $torden);

        // Filtrado
        $campos_estandar = ['denominacion', 'descripcion', 'categoria_id', 'activo', 'iva'];
        $campos_numericos = ['precio', 'stock', 'descuento'];

        foreach ($campos_estandar as $campo) {
            if ((request()->query($campo)) !== null) {
                $productos->where($campo, 'ilike', '%' . request()->query($campo) .'%');
            }
        }

        foreach ($campos_numericos as $campo) {
            if ((request()->query($campo)) !== null) {
                if (is_numeric(request()->query($campo))) {
                    $productos->where($campo, request()->query($campo . '_signo') ?: '=', request()->query($campo));
                }
            }
        }

        // Paginador
        $paginador = $productos->paginate(10);
        $paginador->appends(compact(
            'orden',
            'torden',
            'denominacion',
            'descripcion',
            'categoria_id',
            'activo',
            'precio',
            'precio_signo',
            'iva',
            'stock',
            'stock_signo',
            'descuento',
            'descuento_signo',

        ));

        return view('productos.index', [
            'productos' => $paginador,
            'categorias' => Categoria::all(),
            'campos' => $campos,
        ]);
    }

}
