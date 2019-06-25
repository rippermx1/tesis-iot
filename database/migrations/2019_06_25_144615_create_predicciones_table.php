<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrediccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('predicciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_dispositivo')->nullable(true);
            $table->integer('estado')->nullable(true)->default(0);
            $table->string('tag')->nullable(true);
            $table->time('hora_encendido')->nullable(true);
            $table->time('hora_apagado')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('predicciones');
    }
}
