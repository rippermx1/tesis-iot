<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dispositivos extends Model
{
    protected $table = "dispositivos";
    protected $fillable = ['tag','pin'];

    public function users(){
        return $this->belongsTo("App\User");
    }
}
