<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogErroresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_errores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('usuario_rut');
            $table->foreign('usuario_rut')->references('rut')->on('usuarios');
            $table->string('tipo_error');
            $table->string('detalle');
            $table->text('mensaje');
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
        Schema::dropIfExists('log_errores');
    }
}
