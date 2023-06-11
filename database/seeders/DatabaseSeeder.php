<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Producto;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Seeders
        $this->call([
            CategoriaSeeder::class,
            ImpuestoSeeder::class,
        ]);

        // Factorías
        //User::factory(30)->create();
        //Producto::factory(30)->create();
    }
}
