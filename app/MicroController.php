<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MicroController extends Model
{
    protected $table = "micro_controllers";
    protected $fillable = [
        'nombre',
        'estado',
        'pin1',
        'pin2',
        'pin3',
        'pin4',
        'pin5',
        'pin6'
    ];

    public function devices(){
        return $this->hasMany("App\Dispositivos");
    }
}
