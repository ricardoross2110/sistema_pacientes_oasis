<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTratamientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tratamientos', function (Blueprint $table) {
            $table->increments('folio');
            $table->string('nombre');
            $table->unsignedInteger('tipo_tratamiento_id');
            $table->foreign('tipo_tratamiento_id')->references('id')->on('tipo_tratamientos');
            $table->text('observacion')->null();
            $table->integer('valor');
            $table->integer('paciente_rut');
            $table->foreign('paciente_rut')->references('rut')->on('pacientes');
            $table->integer('num_control');
            $table->char('estado_deuda', 1);
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
        Schema::dropIfExists('tratamientos');
    }
}
