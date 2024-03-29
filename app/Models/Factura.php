<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $dates = ['fecha'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function lineas() {
        return $this->hasMany(Linea::class);
    }
}
