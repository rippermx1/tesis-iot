<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDispositivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispositivos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tag', 100)->nullable(true);
            $table->integer('pin')->nullable(true);
            $table->integer('estado')->nullable(true)->default(0);
            $table->boolean('encendido')->nullable(true)->default(false);
            $table->integer('luminosidad')->nullable(true)->default(0);
            $table->string('icon', 250)->nullable(true);
            $table->integer('id_tipo_dispositivo')->nullable(true);
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
        Schema::dropIfExists('dispositivos');
    }
}
