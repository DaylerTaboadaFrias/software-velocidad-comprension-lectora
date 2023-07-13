<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    protected $table = "categoria";
    protected $appends = ['imagen_movil'];

    public function getImagenMovilAttribute() 
    { 
        return env('APP_URL').'/images/'.$this->imagen;
    }
}
