<?php

namespace App\Http\Controllers;

use App\Models\Direccion;
use App\Models\User;
use Illuminate\Http\Request;

class DireccionesController extends Controller
{
        // Ver direcciones
        public function ver_direcciones(User $user)
        {
            return view('admin.direcciones.ver-direcciones', [
                'user' => $user,
            ]);
        }
}
