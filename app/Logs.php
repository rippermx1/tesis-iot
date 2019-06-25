<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    protected $table = "logs";
    protected $fillable = [
        'id_dispositivo',
        'descripcion',
        'encendido',
        'luminosidad',
        'fecha',
        'hora',
        'created_at',
        'updated_at'
    ];

    public function dispositivo(){
        return $this->belongsTo("App\Dispositivos");
    }
}
