<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ejercicio', function (Blueprint $table) {
            $table->id();
            $table->text('titulo')->nullable(true);
            $table->text('parrafo')->nullable(true);
            $table->text('recomendaciones')->nullable(true);
            $table->integer('puntuacion')->nullable(true);
            $table->integer('velocidad')->nullable(true);
            $table->unsignedBigInteger('nivel_id');
            $table->foreign('nivel_id')->references('id')->on('nivel');
            $table->unsignedBigInteger('tipo_ejercicio_id');
            $table->foreign('tipo_ejercicio_id')->references('id')->on('tipo_ejercicio');
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
        Schema::dropIfExists('ejercicio');
    }
};
