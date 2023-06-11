<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Valoracion extends Model
{
    use HasFactory;

    protected $table = 'valoraciones';

    protected $fillable = [
        'user_id',
        'producto_id',
        'puntuacion',
        'titulo',
        'comentario',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function producto() {
        return $this->belongsTo(Producto::class);
    }

    public function respuestas() {
        return $this->hasMany(Respuesta::class);
    }
}
