<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lectura extends Model
{
    use HasFactory;
    protected $table = 'lectura';
    protected $primaryKey = 'id';
    protected $fillable = ['parrafo', 'id_ejercicio', 'palabras_clave'];
    public $timestamps = false;

    public function ejercicio()
    {
        return $this->hasOne(Ejercicio::class, 'id', 'id_ejercicio');

    }
}
