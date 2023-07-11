<?php

namespace App\Models;

use App\Models\Respuesta;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ejercicio extends Model
{
    use HasFactory;
    protected $table = "ejercicio";
    /**
     * Get the respuesta associated with the Ejercicio
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function respuesta(): HasOne
    {
        return $this->hasOne(Respuesta::class, 'ejercicio_id', 'id');
    }
}
