<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoDispositivo extends Model
{
    protected $table = "tipo_dispositivos";
    protected $fillable = [
        'name'
    ];

    public function dispositivos(){
        return $this->hasMany("App\Dispositivos");
    }
}
