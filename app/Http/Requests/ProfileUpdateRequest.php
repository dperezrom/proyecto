<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2','max:35', 'regex:/(\s?[a-zA-ZáéíóúÁÉÍÓÚñÑ]+){2,4}/'],
            'email' => ['required', 'email', 'max:50', Rule::unique(User::class)->ignore($this->user()->id)],
            'telefono' => ['required', 'digits:9', 'regex:/^[1-9]\d{8}$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El campo «Nombre» es obligatorio',
            'name.string' => 'El campo «Nombre» debe ser una cadena',
            'name.min' => 'El campo «Nombre» necesita al menos 2 caracteres',
            'name.max' => 'El campo «Nombre» solo permite hasta 35 caracteres',
            'name.regex' => 'El campo «Nombre» no tiene el formato correcto ',
            'email.required' => 'El campo «Email» es obligatorio',
            'email.email' => 'El campo «Email» debe contener el formato adecuado',
            'email.max' => 'El campo «Email» solo permite hasta 50 caracteres',
            'email.unique' => 'El email ya existe ',
            'telefono.required' => 'El campo «Teléfono» es obligatorio',
            'telefono.digits' => 'El campo «Teléfono» debe contener 9 dígitos',
            'telefono.regex' => 'El campo «Teléfono» no tiene el formato correcto '
        ];
    }
}
