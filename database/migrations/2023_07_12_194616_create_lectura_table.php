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
        Schema::create('lectura', function (Blueprint $table) {
            $table->id();
            $table->text('parrafo')->nullable(true);
            $table->text('palabras_clave')->nullable(true);
            $table->unsignedBigInteger('id_ejercicio');
            $table->foreign('id_ejercicio')->references('id')->on('ejercicio');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lectura');
    }
};
