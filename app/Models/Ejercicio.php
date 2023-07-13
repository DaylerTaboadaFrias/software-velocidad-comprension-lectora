<?php

namespace App\Models;

use App\Models\Respuesta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ejercicio extends Model
{
    use HasFactory;
    protected $table = 'ejercicio';
    protected $primaryKey = 'id';
    protected $fillable = ['recomendaciones', 'velocidad', 'nivel_id', 'tipo_ejercicio_id'];
    public $timestamps = true;


    public function lectura()
    {
        return $this->hasMany(Lectura::class, 'id_ejercicio', 'id');
    }

    public function Tipo()
    {

        return $this->hasOne(Tipo::class, 'id', 'tipo_ejercicio_id');
    }

    public function Nivel()
    {
        return $this->hasOne(Nivel::class, 'id', 'nivel_id');

    }

}
