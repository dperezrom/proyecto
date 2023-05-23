<?php

namespace App\Http\Controllers;

use App\Mail\NotificarPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Campos buscador
        $campos = [
            'name',
            'email',
            'telefono',
            'rol',
        ];

        foreach ($campos as $campo) {
            ${$campo} = request()->query($campo);
        }

        $orden = request()->query('orden') ?: 'name';
        abort_unless(in_array($orden, $campos), 404);
        $torden = request()->query('torden') ?: 'ASC';

        $users = User::orderBy($orden, $torden);

        foreach ($campos as $campo) {
            if ((request()->query($campo)) !== null) {
                $users->where($campo, 'ilike', '%' . request()->query($campo) . '%');
            }
        }

        // Paginador
        $paginador = $users->paginate(10);
        $paginador->appends(compact(
            'orden',
            'torden',
            'name',
            'email',
            'telefono',
            'rol',
        ));

        return view('admin.users.index', [
            'users' => $paginador,
            'campos' => $campos,
        ]);
    }

     // Validación
     public function validar()
     {
         $validados = request()->validate([
             'name' => ['required', 'string','min:2', 'max:35'],
             'email' => ['required', 'string', 'email', 'max:50', 'unique:'.User::class],
             'telefono' => ['required', 'digits:9'],
             'rol' => ['required','in:usuario,admin'],

         ], [
             'name.required' => 'El campo «Nombre» es obligatorio',
             'name.min' => 'El campo «Nombre» necesita al menos 2 caracteres',
             'name.max' => 'El campo «Nombre» solo permite hasta 30 caracteres',
             'email.required' => 'El campo «Email» es obligatorio',
             'email.email' => 'El campo «Email» debe contener el formato adecuado',
             'email.max' => 'El campo «Email» solo permite hasta 50 caracteres',
             'email.unique' => 'El email ya existe ',
             'telefono.required' => 'El campo «Teléfono» es obligatorio',
             'telefono.digits' => 'El campo «Teléfono» debe contener 9 dígitos',
             'rol.required' => 'El campo «Rol» es obligatorio',
             'rol.in' => 'El campo «Rol» contiene un valor incorrecto',
         ]);

         return $validados;
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create', [
            'user' => new User(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validados = $this->validar();

        $user = new User();
        $user->name = ucfirst(trim($validados['name']));
        $user->email = trim(mb_strtolower($validados['email']));
        $pass = Str::random(10);
        $user->password = Hash::make($pass);
        $user->telefono = $validados['telefono'];
        $user->rol = $validados['rol'];

        $user->save();
        Mail::to($user->email)->send(new NotificarPassword($user, $pass));

        return redirect()->route('admin.users')->with('success', 'Usuario creado con éxito.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
