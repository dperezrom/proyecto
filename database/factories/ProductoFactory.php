<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'denominacion' => fake()->name(),
            'descripcion' => 'Descripción genérica',
            'precio' => rand(1, 100),
            'iva' => 21,
            'activo' => true,
            'stock' => 10,
            'descuento' => 0,
            'categoria_id' => fake()->randomElement([1,2,3,4]),
        ];
    }
}
