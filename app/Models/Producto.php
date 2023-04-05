<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable=[
        'denominacion',
        'descripcion',
        'precio',
        'iva',
        'stock',
        'activo',
        'descuento',
        'categoria_id',
        'imagen'
    ];

    public function categoria() {
        return $this->belongsTo(Categoria::class);
    }

    public function lineas() {
        return $this->hasMany(Linea::class);
    }

    public function valoraciones() {
        return $this->hasMany(Valoracion::class);
    }
}
