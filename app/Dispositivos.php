<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dispositivos extends Model
{
    protected $table = "dispositivos";
    protected $fillable = [
        'tag',
        'pin',
        'estado',
        'encendido',
        'luminosidad',
        'icon',
        'id_tipo_dispositivo',
        'id_micro_controlador',
        'created_at',
        'updated_at'
    ];

    public function user(){
        return $this->belongsTo("App\User");
    }

    public function logs(){
        return $this->hasMany("App\Logs");
    }

    public function prediccion(){
        return $this->belongsTo("App\Predicciones");
    }

    public function tipo(){
        return $this->belongsTo("App\TipoDispositivo");
    }

    public function microcontrolador(){
        return $this->belongsTo("App\MicroController");
    }
}
