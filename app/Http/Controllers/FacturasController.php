<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FacturasController extends Controller
{
    // Ver facturas
    public function ver_facturas(User $user)
    {
        $paginador = $user->facturas()->paginate(10);

        return view('admin.facturas.ver-facturas', [
            'user' => $user,
            'paginador' => $paginador,
        ]);
    }
}
