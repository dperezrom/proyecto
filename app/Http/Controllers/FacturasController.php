<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function ver_mis_facturas(Request $request)
    {
        $paginador = Auth::user()->facturas()->paginate(10);

        return view('facturas.mis-facturas', [
            'user' => Auth::user(),
            'paginador' => $paginador,
        ]);
    }
}
