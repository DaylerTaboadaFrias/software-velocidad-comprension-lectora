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
        Schema::table('ejercicio', function (Blueprint $table) {
            $table->dropColumn('parrafo');
            $table->dropColumn('puntuacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ejercicio', function (Blueprint $table) {
            $table->text('parrafo')->nullable(true);
            $table->decimal('puntuacion', 11, 2)->nullable(true);
        });
    }
};
