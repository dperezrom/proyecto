<?php

namespace App\Http\Controllers\Auth;

use App\Common\Utilities;
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
        $email_pattern = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/';
        $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:35'],
            'email' => ['required', 'string', 'email', 'regex:' . $email_pattern, 'max:50', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults(), 'min:8'],
            'telefono' => ['required', 'digits:9'],
            'documento' => ['required', 'regex:/^[XYZ]?\d{5,8}[A-Z]/', 'unique:' . User::class,
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
            'name.max' => 'El campo «Nombre» solo permite hasta 35 caracteres',
            'email.required' => 'El campo «Email» es obligatorio',
            'email.max' => 'El campo «Email» solo permite hasta 50 caracteres',
            'email.unique' => 'El email ya existe',
            'email.email' => 'El campo «Email» debe contener el formato adecuado',
            'email.regex' => 'El campo «Email» debe contener el formato adecuado',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña necesita al menos 8 caracteres',
            'password.confirmed' => 'Ambas contraseñas deben coincidir',
            'telefono.required' => 'El campo «Teléfono» es obligatorio',
            'telefono.digits' => 'El campo «Teléfono» debe contener 9 dígitos',
            'documento.required' => 'El campo «DNI/NIE» es obligatorio',
            'documento.regex' => 'El campo «DNI/NIE» debe contener el formato adecuado',
            'documento.unique' => 'El DNI/NIE ya existe',
            'fecha_nac.required' => 'El campo «Fecha de Nacimiento» es obligatorio',
        ]);

        $user = User::create([
            'name' => trim(mb_convert_case($request->name, MB_CASE_TITLE, "UTF-8")),
            'email' => trim(mb_strtolower($request->email)),
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'documento' => trim(mb_strtoupper($request->documento)),
            'fecha_nac' => $request->fecha_nac,
            'rol' => 'usuario',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
