<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoria1 = new Categoria();
        $categoria1->nombre = 'Hogar';
        $categoria1->descripcion = 'Muebles para hogar';
        $categoria1->save();

        $categoria2 = new Categoria();
        $categoria2->nombre = 'Videojuegos';
        $categoria2->descripcion = 'Consolas y videojuegos';
        $categoria2->save();

        $categoria3 = new Categoria();
        $categoria3->nombre = 'Informática';
        $categoria3->descripcion = 'Monitores, portátiles, tablets, almacenamiento de datos y accesorios';
        $categoria3->save();

        $categoria4 = new Categoria();
        $categoria4->nombre = 'Mascotas';
        $categoria4->descripcion = 'Productos para mascotas';
        $categoria4->save();


    }
}
