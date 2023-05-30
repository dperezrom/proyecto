<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string','min:2', 'max:35'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults(), 'min:8'],
            'telefono' => ['required', 'digits:9'],
        ], [
            'name.required' => 'El campo «Nombre» es obligatorio',
            'name.min' => 'El campo «Nombre» necesita al menos 2 caracteres',
            'name.max' => 'El campo «Nombre» solo permite hasta 35 caracteres',
            'email.required' => 'El campo «Email» es obligatorio',
            'email.email' => 'El campo «Email» debe contener el formato adecuado',
            'email.max' => 'El campo «Email» solo permite hasta 50 caracteres',
            'email.unique' => 'El email ya existe ',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña necesita al menos 8 caracteres',
            'password.confirmed' => 'Ambas contraseñas deben coincidir',
            'telefono.required' => 'El campo «Teléfono» es obligatorio',
            'telefono.digits' => 'El campo «Teléfono» debe contener 9 dígitos',
        ]);

        $user = User::create([
            'name' => trim(mb_convert_case($request->name, MB_CASE_TITLE, "UTF-8")),
            'email' => trim(mb_strtolower($request->email)),
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'rol' => 'usuario',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
