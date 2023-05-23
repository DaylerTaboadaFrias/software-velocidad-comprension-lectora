<?php

namespace App\Models;

use App\Enums\Removed;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        "name", "cost", "amount_days", "type", "removed"
    ];

    protected static function booted() {
        static::addGlobalScope("activados", function (Builder $builder) {
            $builder->whereRemoved(Removed::Activado);
        });
    }

    public function beneficios()
    {
        return $this->hasMany(Benefit::class, 'plan_id', 'id');
    }
}
