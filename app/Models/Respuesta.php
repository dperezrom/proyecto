<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    use HasFactory;

    protected $fillable=[
        'comentario',
        'valoracion_id',
    ];

    public function valoracion() {
        return $this->belongsTo(Valoracion::class);
    }
}
