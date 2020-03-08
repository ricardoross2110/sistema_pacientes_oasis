<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAtencionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atenciones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('num_atencion');
            $table->text('observacion')->null();
            $table->dateTime('fecha');
            $table->integer('abono');
            $table->unsignedInteger('tratamiento_folio');
            $table->foreign('tratamiento_folio')->references('folio')->on('tratamientos');
            $table->integer('profesional_rut');
            $table->foreign('profesional_rut')->references('rut')->on('profesionales');
            $table->unsignedInteger('sucursal_id');
            $table->foreign('sucursal_id')->references('id')->on('sucursales');
            $table->integer('usuario_rut');
            $table->foreign('usuario_rut')->references('rut')->on('usuarios');
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
        Schema::dropIfExists('atenciones');
    }
}
