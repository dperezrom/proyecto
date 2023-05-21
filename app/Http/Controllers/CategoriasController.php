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

        $paginador = $categorias->paginate(5);

        $paginador->appends(compact(
            'nombre',
            'descripcion',
            'orden',
            'torden'
        ));

        return view('admin.categorias.index', [
            'categorias' => $paginador
        ]);

    }

    // Validación
    public function validar()
    {
        $validados = request()->validate([
            'nombre' => 'required|string|max:30',
            'descripcion' => 'required|max:255',

        ],[
            'nombre.required' => 'El campo «Nombre» es obligatorio',
            'nombre.string' => 'El campo «Nombre» debe ser una cadena',
            'nombre.max' => 'El campo «Nombre» solo permite hasta 30 caracteres',
            'descripcion.required' => 'El campo «Descripción» es obligatorio',
            'descripcion.max' => 'El campo «Descripción» solo permite hasta 255 caracteres',

        ]);

        return $validados;
    }

    // Crear categoría
    public function create()
    {
        $categoria = new Categoria();
        return view('admin.categorias.create', ['categoria' => $categoria,]);
    }

    public function store()
    {
        $validados = $this->validar();

        $categoria = new Categoria();
        $categoria->nombre = ucfirst(trim($validados['nombre']));
        $categoria->descripcion = ucfirst(trim($validados['descripcion']));

        $categoria->save();

        return redirect()->route('admin.categorias')->with('success', 'Categoría creada con éxito.');
    }

    // Editar categoría
    public function edit(Categoria $categoria)
    {
        return view('admin.categorias.edit', ['categoria' => $categoria]);
    }

    public function update(Categoria $categoria)
    {
        $validados = $this->validar();

        $categoria->nombre = ucfirst(trim($validados['nombre']));
        $categoria->descripcion = ucfirst(trim($validados['descripcion']));

        $categoria->save();

        return redirect()->route('admin.categorias')->with('success', 'Categoría actualizada');
    }

    // Borrar categoría
    public function destroy(Categoria $categoria)
    {
        if ($categoria->productos->isNotEmpty()) {
            return redirect()->route('admin.categorias')->with('error', 'La categoría contiene productos.');
        }

        $categoria->delete();

        return redirect()->route('admin.categorias')->with('success', 'Producto eliminado con éxito.');

    }

}
