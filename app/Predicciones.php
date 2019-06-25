<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Predicciones extends Model
{
    protected $table = "predicciones";
    protected $fillable = [
        'id_dispositivo',
        'estado',
        'tag',
        'hora_encendido',
        'hora_apagado',
        'created_at',
        'updated_at'
    ];

    public function dispositivo(){
        return $this->belongsTo("App\Dispositivos");
    }
}
