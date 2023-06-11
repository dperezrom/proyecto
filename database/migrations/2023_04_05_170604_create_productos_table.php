<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('denominacion');
            $table->text('descripcion');
            $table->decimal('precio', 7, 2);
            $table->foreignId('impuesto_id')->constrained('impuestos');
            $table->integer('stock');
            $table->string('activo');
            $table->integer('descuento');
            $table->string('imagen')->nullable();
            $table->foreignId('categoria_id')->constrained('categorias');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
};
