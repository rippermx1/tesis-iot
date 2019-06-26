<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMicroControllersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('micro_controllers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre')->nullable(true);
            $table->integer('estado')->nullable(true)->default(0);
            $table->integer('pin1')->nullable(true)->default(0);
            $table->integer('pin2')->nullable(true)->default(0);
            $table->integer('pin3')->nullable(true)->default(0);
            $table->integer('pin4')->nullable(true)->default(0);
            $table->integer('pin5')->nullable(true)->default(0);
            $table->integer('pin6')->nullable(true)->default(0);
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
        Schema::dropIfExists('micro_controllers');
    }
}
