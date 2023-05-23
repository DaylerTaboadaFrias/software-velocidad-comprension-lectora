<?php

namespace App\Models;

use App\Enums\Removed;
use App\Models\UserEvent;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;
    /**
     * Get the photo1
     *
     * @param  string  $value
     * @return string url imagen
     */
    public function getImagenAttribute($value)
    {
        return env('APP_URL_IMAGES').$value;
    }
    protected $fillable = ['fecha','hora_inicio','hora_fin','imagen','cantidad_personas','detalle','nombre','direccion','type_event_id'];

    protected static function booted() {
        static::addGlobalScope("activados", function (Builder $builder) {
            $builder->whereRemoved(Removed::Activado);
        });
    }
    protected static function boot()
    {
        parent::boot();
        self::creating(function(Event $event) {
            do {
                $token = Str::uuid();
            } while (Event::where("code_qr", $token)->first() instanceof Event);
            $event->code_qr = $token;
            $qrImagen = 'storage/qrs/'.date('YmdHis').'.svg';
            $event->code_qr_imagen = $qrImagen;
            QrCode::generate($token, $qrImagen);
        });
    }

    public function user_event()
    {
        return $this->hasOne(UserEvent::class);
    }
}
