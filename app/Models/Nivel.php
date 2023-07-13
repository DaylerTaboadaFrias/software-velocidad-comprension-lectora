<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nivel extends Model
{
    use HasFactory;
    protected $table = 'nivel';
    protected $primaryKey = 'id';
    protected $fillable = ['descripcion', 'nombre', 'categoria_id'];
    public $timestamps = true;

    protected $appends = ['imagen_movil'];

    public function getImagenMovilAttribute()
    {
        return env('APP_URL_IMAGES') . $this->imagen;
    }

}
