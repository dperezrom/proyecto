<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Valoracion;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Empty_;

class ValoracionesController extends Controller
{

    // Ver valoraciones
    public function ver_valoraciones(Producto $producto)
    {
        // Orden por fecha de creación
        $orden = request()->query('orden') ?: 'desc';
        abort_unless(in_array($orden, ['asc', 'desc']), 404);

        $valoraciones = $producto->valoraciones()->orderBy('created_at', $orden);
        $paginador = $valoraciones->paginate(10);
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
            'titulo' => ['required', 'string', 'max:50'],
            'comentario' => ['required','max:255'],
            'puntuacion' => ['required', 'integer', 'between:1,5'],
            'producto_id' => ['required', 'integer'],

        ], [
            'titulo.required' => 'El campo «Título» es obligatorio',
            'titulo.string' => 'El campo «Título» debe ser una cadena',
            'titulo.max' => 'El campo «Título» solo permite hasta 50 caracteres',
            'comentario.required' => 'El campo «Comentario» es obligatorio',
            'comentario.max' => 'El campo «Comentario» solo permite hasta 255 caracteres',
            'puntuacion.required' => 'El campo «Puntuación» es obligatorio',
            'puntuacion.integer' => 'El campo «Puntuación» debe ser un número entero',
            'puntuacion.between' => 'El campo «Puntuación» tiene que ser de 1 a 5',
            'producto_id.required' => 'El campo «Producto» es obligatorio',
            'producto_id.integer' => 'El campo «Producto» debe ser un número entero',
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

    // Vista crear valoración
    public function create(Producto $producto)
    {
        if(empty($producto) || in_array(Auth::id(), array_column($producto->valoraciones->toArray(),'user_id'))){
            abort(404);
        }

        $valoracion = new Valoracion();
        return view('valoraciones.create', [
            'valoracion' => $valoracion,
            'producto' => $producto,
        ]);
    }

    // Crear valoración usuario

    public function crear_valoracion()
    {
        $validados = $this->validar();

        $producto = Producto::find($validados['producto_id']);
        if(empty($producto) || in_array(Auth::id(), array_column($producto->valoraciones->toArray(),'user_id'))){
            abort(404);
        }

        $valoracion = new Valoracion();
        $valoracion->user_id = Auth::id();
        $valoracion->producto_id = $validados['producto_id'];
        $valoracion->puntuacion = $validados['puntuacion'];
        $valoracion->titulo = ucfirst(trim($validados['titulo']));
        $valoracion->comentario = ucfirst(trim($validados['comentario']));

        $valoracion->save();

        return redirect()->route('productos.ver-producto', $valoracion->producto_id)->with('success', 'Valoración creada con éxito.');
    }


    // Modificar valoración usuario
 /*   public function modificar_valoracion(Producto $producto)
    {
        $validados = $this->validar();

        $valoracion->titulo = ucfirst(trim($validados['titulo']));
        $valoracion->comentario = ucfirst(trim($validados['comentario']));

        $valoracion->save()
    }*/
}
