<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    use HasFactory;

    protected $table = 'tipo_ejercicio';
    protected $primaryKey = 'id';
    protected $fillable = ['nombre'];
    public $timestamps = true;
}
