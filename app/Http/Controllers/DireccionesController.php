<?php

namespace App\Http\Controllers;

use App\Models\Direccion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Psr\Container\NotFoundExceptionInterface;

class DireccionesController extends Controller
{
    // Ver direcciones admin
    public function ver_direcciones(User $user)
    {
        return view('admin.direcciones.ver-direcciones', [
            'user' => $user,
        ]);
    }

    // Ver direcciones usuario
    public function ver_mis_direcciones(Request $request)
    {
        return view('direcciones.mis-direcciones', [
            'user' => $request->user(),
        ]);
    }


    // Página crear dirección usuario
    public function create()
    {
        $direccion = new Direccion();

        return view('direcciones.create', [
            'direccion' => $direccion,
        ]);
    }

    // Crear dirección
    public function store(Request $request)
    {
        $validados = $this->validar();

        $direccion = new Direccion();
        $direccion->nombre = mb_convert_case(trim($validados['nombre']), MB_CASE_TITLE, 'UTF-8');
        $direccion->calle = $validados['calle'];
        $direccion->telefono = $validados['telefono'];
        $direccion->ciudad = mb_convert_case(trim($validados['ciudad']), MB_CASE_TITLE, 'UTF-8');
        $direccion->provincia = mb_convert_case(trim($validados['provincia']), MB_CASE_TITLE, 'UTF-8');
        $direccion->cp = $validados['cp'];
        $direccion->instruccion = $validados['instruccion'];
        $direccion->user_id = Auth::id();

        $direccion->save();

        return redirect()->route('direcciones.mis-direcciones')->with('success', 'Dirección creada con éxito.');
    }

    // Página editar dirección usuario
    public function edit(Direccion $direccion)
    {
        if(Auth::id() != $direccion->user_id) {
            abort(404);
        }

        return view('direcciones.edit', ['direccion' => $direccion]);
    }

    // Editar dirección
    public function update(Direccion $direccion)
    {
        if(Auth::id() != $direccion->user_id) {
            abort(404);
        }

        $validados = $this->validar();
        $direccion->nombre = mb_convert_case(trim($validados['nombre']), MB_CASE_TITLE, 'UTF-8');
        $direccion->calle = $validados['calle'];
        $direccion->telefono = $validados['telefono'];
        $direccion->ciudad = mb_convert_case(trim($validados['ciudad']), MB_CASE_TITLE, 'UTF-8');
        $direccion->provincia = mb_convert_case(trim($validados['provincia']), MB_CASE_TITLE, 'UTF-8');
        $direccion->cp = $validados['cp'];
        $direccion->instruccion = $validados['instruccion'];

        $direccion->save();

        return redirect()->route('direcciones.mis-direcciones')->with('success', 'Dirección actualizada con éxito');
    }

    // Borrar dirección
    public function destroy(Direccion $direccion)
    {
        if(Auth::id() != $direccion->user_id) {
            abort(404);
        }

        $direccion->delete();

        return back()->with('success', 'Dirección eliminada con éxito.');
    }

    // Validación
    public function validar()
    {
        $validados = request()->validate([
            'nombre' => ['required', 'max:50', 'regex:/^([a-zA-ZáéíóúÁÉÍÓÚñÑ]+\s?)+/'],
            'calle' => ['required', 'max:50'],
            'telefono' => ['required', 'digits:9', 'regex:/^[1-9]\d{8}$/'],
            'ciudad' => ['required', 'max:50', 'regex:/^([a-zA-ZáéíóúÁÉÍÓÚñÑ]+\s?)+/'],
            'provincia' => ['required', 'max:50', 'regex:/^([a-zA-ZáéíóúÁÉÍÓÚñÑ]+\s?)+/'],
            'cp' => ['required', 'digits:5', 'regex:/^\d{5}$/'],
            'instruccion' => ['max:250'],

        ], [
            'nombre.required' => 'El campo «Nombre» es obligatorio',
            'nombre.max' => 'El campo «Nombre» solo permite hasta 50 caracteres',
            'nombre.regex' => 'El campo «Nombre» no tiene el formato correcto',
            'calle.required' => 'El campo «Calle» es obligatorio',
            'calle.max' => 'El campo «Calle» solo permite hasta 50 caracteres',
            'telefono.required' => 'El campo «Teléfono» es obligatorio',
            'telefono.digits' => 'El campo «Teléfono» debe contener 9 dígitos',
            'telefono.regex' => 'El campo «Teléfono» no tiene el formato correcto',
            'ciudad.required' => 'El campo «Ciudad» es obligatorio',
            'ciudad.max' => 'El campo «Ciudad» solo permite hasta 50 caracteres',
            'ciudad.regex' => 'El campo «Ciudad» no tiene el formato correcto',
            'provincia.required' => 'El campo «Provincia» es obligatorio',
            'provincia.max' => 'El campo «Provincia» solo permite hasta 50 caracteres',
            'provincia.regex' => 'El campo «Provincia» no tiene el formato correcto',
            'cp.required' => 'El campo «Código Postal» es obligatorio',
            'cp.digits' => 'El campo «Código Postal» debe contener 5 dígitos',
            'cp.regex' => 'El campo «Código Postal» no tiene el formato correcto',
            'instruccion.max' => 'El campo «Instrucción» solo permite hasta 250 caracteres',
        ]);

        return $validados;
    }
}
