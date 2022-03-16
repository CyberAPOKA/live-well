<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HistoricoNucleos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historico_nucleos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('nucleo_id')->nullable();
            $table->Integer('inativo')->nullable();
            $table->string('comentario')->nullable();
            $table->string('operario')->nullable();
            $table->foreign('nucleo_id')->references('id')->on('nucleos')->onDelete('cascade');
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
        Schema::dropIfExists('historico_nucleos');
    }
}
