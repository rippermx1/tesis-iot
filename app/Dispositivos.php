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
}
