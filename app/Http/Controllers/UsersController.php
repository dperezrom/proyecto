<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
