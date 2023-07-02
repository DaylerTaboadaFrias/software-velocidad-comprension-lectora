<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    protected $table = "categoria";
    public function levels()
    {
        return $this.hasMany(Level::class,'category_id');
    }
}
