<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfesionalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profesionales', function (Blueprint $table) {
            $table->integer('rut')->primary();
            $table->char('dv', 1);
            $table->string('nombres');
            $table->string('apellido_paterno');
            $table->string('apellido_materno');
            $table->string('direccion');
            $table->string('telefono');
            $table->string('email')->unique();
            $table->text('observacion')->null();
            $table->dateTime('fecha_registro');
            $table->char('estado', 1);
            $table->unsignedInteger('cargo_id')->null();
            $table->foreign('cargo_id')->references('id')->on('cargos');
            $table->unsignedInteger('tipo_contrato_id');
            $table->foreign('tipo_contrato_id')->references('id')->on('tipo_contrato');
            $table->unsignedInteger('profesion_id');
            $table->foreign('profesion_id')->references('id')->on('profesiones');
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
        Schema::dropIfExists('profesionales');
    }
}
