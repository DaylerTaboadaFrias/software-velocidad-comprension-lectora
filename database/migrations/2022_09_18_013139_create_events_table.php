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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('code_qr',100)->nullable($value = true);
            $table->string('direccion')->nullable($value = true);
            $table->date('fecha');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->string('imagen');
            $table->string('code_qr_imagen');
            $table->integer('cantidad_personas');
            $table->string('detalle')->nullable($value = true);
            $table->enum('removed', ['Activado', 'Eliminado'])->default('Activado');
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
     
        Schema::dropIfExists('events');
    }
};
