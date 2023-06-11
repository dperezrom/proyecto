<?php

namespace App\Http\Controllers;

use App\Common\Utilities;
use App\Mail\NotificarPassword;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class UsersController extends Controller
{

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Campos buscador
        $campos = [
            'name',
            'documento',
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
            'documento',
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

    /**
     * @param User $user
     * @return array
     */
    public function validar(User $user): array
    {
        $userId = empty($user->id) ? '' : ',' . $user->id;

        return request()->validate([
            'name' => ['required', 'string', 'min:2', 'max:35'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:users,email' . $userId],
            'telefono' => ['required', 'digits:9'],
            'rol' => ['required', 'in:usuario,admin'],
            'documento' => ['required', 'regex:/^[XYZ]?\d{5,8}[A-Z]/', 'unique:users,documento' . $userId,
                function ($attribute, $value, $fail) {
                    Utilities::validateDNINIE($value) ?: $fail('El DNI/NIE es incorrecto.');
                }],
            'fecha_nac' => ['required', function ($attribute, $value, $fail) {
                Utilities::validateDate($value, 'Y-m-d') ?: $fail('La fecha de nacimiento es incorrecta.');
            }, function ($attribute, $value, $fail) {
                Utilities::validateLegalAge($value, 'Y-m-d') ?: $fail('No eres mayor de edad.');
            }],

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
            'documento.required' => 'El campo «DNI/NIE» es obligatorio',
            'documento.regex' => 'El campo «DNI/NIE» debe contener el formato adecuado',
            'documento.unique' => 'El DNI/NIE ya existe',
            'fecha_nac.required' => 'El campo «Fecha de Nacimiento» es obligatorio',
            'rol.required' => 'El campo «Rol» es obligatorio',
            'rol.in' => 'El campo «Rol» contiene un valor incorrecto',
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.users.create', [
            'user' => new User(),
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $user = new User();
        $validados = $this->validar($user);
        $user->name = ucfirst(trim($validados['name']));
        $user->email = trim(mb_strtolower($validados['email']));
        $pass = Str::random(10);
        $user->password = Hash::make($pass);
        $user->telefono = $validados['telefono'];
        $user->documento = trim(mb_strtoupper($validados['documento']));
        $user->fecha_nac = $validados['fecha_nac'];
        $user->rol = $validados['rol'];

        $user->save();
        // MODO PRODUCCIÓN
        //Mail::to($user->email)->send(new NotificarPassword($user, $pass));
        // MODO PRUEBAS
        Mail::to('danieldeveloper95@gmail.com')->send(new NotificarPassword($user, $pass));

        return redirect()->route('admin.users')->with('success', 'Usuario creado con éxito.');
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(User $user)
    {
        return view('admin.users.show', ['user' => $user,]);
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', ['user' => $user,]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $validados = $this->validar($user);
        $user->name = ucfirst(trim($validados['name']));
        $user->email = trim(mb_strtolower($validados['email']));
        $user->telefono = $validados['telefono'];
        $user->documento = trim(mb_strtoupper($validados['documento']));
        $user->fecha_nac = $validados['fecha_nac'];
        $user->rol = $validados['rol'];

        $user->save();

        return redirect()->route('admin.users')->with('success', 'Usuario actualizado');
    }

    /**
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user)
    {
        if ($user->direcciones->isNotEmpty()) {
            return redirect()->route('admin.users')->with('error', 'El usuario contiene direcciones.');
        }

        if ($user->facturas->isNotEmpty()) {
            return redirect()->route('admin.users')->with('error', 'El usuario contiene facturas.');
        }

        if ($user->valoraciones->isNotEmpty()) {
            return redirect()->route('admin.users')->with('error', 'El usuario contiene valoraciones.');
        }
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Usuario eliminado con éxito.');
    }
}
