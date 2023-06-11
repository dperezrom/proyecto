<?php

namespace Database\Seeders;

use App\Models\Impuesto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImpuestoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $impuesto1 = new Impuesto();
        $impuesto1->descripcion = 'IVA general';
        $impuesto1->porcentaje = 21;
        $impuesto1->save();

        $impuesto2 = new Impuesto();
        $impuesto2->descripcion = 'IVA reducido';
        $impuesto2->porcentaje = 10;
        $impuesto2->save();

        $impuesto3 = new Impuesto();
        $impuesto3->descripcion = 'IVA superreducido';
        $impuesto3->porcentaje = 4;
        $impuesto3->save();

        $impuesto4 = new Impuesto();
        $impuesto4->descripcion = 'Sin IVA';
        $impuesto4->porcentaje = 0;
        $impuesto4->save();
    }
}
