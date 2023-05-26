<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Valoracion;

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

    // Validación
    public function validar()
    {
        $validados = request()->validate([
            'titulo' => 'required|string|max:50',
            'comentario' => 'required|max:255',

        ], [
            'titulo.required' => 'El campo «Título» es obligatorio',
            'titulo.string' => 'El campo «Título» debe ser una cadena',
            'titulo.max' => 'El campo «Título» solo permite hasta 50 caracteres',
            'comentario.required' => 'El campo «Comentario» es obligatorio',
            'comentario.max' => 'El campo «Comentario» solo permite hasta 255 caracteres',

        ]);

        return $validados;
    }

    // Editar categoría
    public function edit(Valoracion $valoracion)
    {
        return view('admin.valoraciones.edit', ['valoracion' => $valoracion]);
    }

    public function update(Valoracion $valoracion)
    {
        $validados = $this->validar();

        $valoracion->titulo = ucfirst(trim($validados['titulo']));
        $valoracion->comentario = ucfirst(trim($validados['comentario']));

        $valoracion->save();

        return redirect()->route('admin.valoraciones.ver-valoraciones', $valoracion->producto_id)->with('success', 'Valoración modificada con éxito.');
    }

    // Borrar
    public function destroy(Valoracion $valoracion)
    {
        $valoracion->delete();

        return redirect()->back()->with('success', 'Valoración eliminada con éxito.');
    }
}
