<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Level extends Model
{
    use HasFactory;

    protected $table = "nivel";
    public function category()
    {
        return $this->belongsTo(Category::class,'categoria_id');
    }
}
