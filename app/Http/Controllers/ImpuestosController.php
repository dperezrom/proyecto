<?php

namespace App\Http\Controllers;

use App\Models\Impuesto;
use Illuminate\Http\Request;

class ImpuestosController extends Controller
{
    public function index()
    {
        $impuestos = Impuesto::orderBy('porcentaje','desc');
        $paginador = $impuestos->paginate(10);
        return view('admin.impuestos.index', [
            'impuestos' => $paginador,
        ]);
    }

    public function validar()
    {
        return request()->validate([
            'descripcion' => ['required', 'max:50'],
            'porcentaje' => ['required', 'integer', 'between:0,100'],
        ],[
            'descripcion.required' => 'El campo «Descripción» es obligatorio',
            'descripcion.max' => 'El campo «Descripción» solo permite hasta 255 caracteres',
            'porcentaje.required' => 'El campo «Porcentaje» es obligatorio',
            'porcentaje.integer' => 'El campo «Porcentaje» debe ser un número entero',
            'porcentaje.between' => 'El campo «Porcentaje» tiene que ser de 0 a 100',
        ]);
    }

    // Vista crear impuesto
    public function create()
    {
        $impuesto = new Impuesto();
        return view('admin.impuestos.create', ['impuesto' => $impuesto,]);
    }

    // Crear impuesto
    public function store()
    {
        $validados = $this->validar();

        $impuesto = new Impuesto();
        $impuesto->descripcion = ucfirst(trim($validados['descripcion']));
        $impuesto->porcentaje = $validados['porcentaje'];

        $impuesto->save();

        return redirect()->route('admin.impuestos')->with('success', 'Impuesto creado con éxito.');
    }

    // Vista editar impuesto
    public function edit(Impuesto $impuesto)
    {
        return view('admin.impuestos.edit', ['impuesto' => $impuesto]);
    }

    // Editar impuesto
    public function update(Impuesto $impuesto)
    {
        $validados = $this->validar();

        $impuesto->descripcion = ucfirst(trim($validados['descripcion']));
        $impuesto->porcentaje = $validados['porcentaje'];

        $impuesto->save();

        return redirect()->route('admin.impuestos')->with('success', 'Impuesto actualizado con éxito');
    }

    // Eliminar impuesto
    public function destroy(Impuesto $impuesto)
    {
        if ($impuesto->productos->isNotEmpty()) {
            return redirect()->route('admin.impuestos')->with('error', 'El impuesto es usado en algunos productos.');
        }

        $impuesto->delete();

        return redirect()->route('admin.impuestos')->with('success', 'Impuesto eliminado con éxito.');

    }
}
