<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->bigIncrements('id');
	    $table->integer('id_dispositivo')->nullable(true);
	    $table->string('descripcion', 100)->nullable(true);
	    $table->integer('encendido')->nullable(true);
	    $table->integer('luminosidad')->nullable(true);
	    $table->date('fecha')->nullable(true);
	    $table->time('hora')->nullable(true);
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
        Schema::dropIfExists('logs');
    }
}
