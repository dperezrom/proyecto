<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag(
            'updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
            ],[
                'current_password.required' => 'El campo «Contraseña Actual» es obligatorio',
                'current_password.current_password' => 'La contraseña actual es incorrecta',
                'password.required' => 'El campo «Contraseña» es obligatorio',
                'password.min' => 'El campo «Contraseña» necesita al menos 8 caracteres',
                'password.confirmed' => 'Las contraseñas no coinciden',
            ]

    );

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }
}
