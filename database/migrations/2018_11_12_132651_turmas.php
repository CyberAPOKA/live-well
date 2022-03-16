<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Turmas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turmas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->string('limite')->nullable();
            $table->string('quant_atual')->default(0);
            $table->string('data_semanal')->nullable();
            $table->string('horario_inicial')->nullable();
            $table->string('horario_final')->nullable();
            $table->integer('inativo')->nullable();
            $table->string('descricao')->nullable();
            $table->unsignedInteger('nucleo_id')->nullable();
            $table->foreign('nucleo_id')->references('id')->on('nucleos')->onDelete('set null');
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
        Schema::dropIfExists('turmas');
    }
}
