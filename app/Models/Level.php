<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $table = "nivel";
    public function category()
    {
        return $this->belongsTo(category::class,'categoria_id');
    }
}
