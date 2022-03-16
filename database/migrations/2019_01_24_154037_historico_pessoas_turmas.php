<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HistoricoPessoasTurmas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historico_pessoas_turmas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('turma_id')->nullable();
            $table->unsignedInteger('pessoa_id')->nullable();
            $table->Integer('inativo')->nullable();
            $table->string('comentario')->nullable();
            $table->string('operario')->nullable();
            $table->foreign('turma_id')->references('id')->on('turmas')->onDelete('cascade');
            $table->foreign('pessoa_id')->references('id')->on('pessoas')->onDelete('cascade');
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
        Schema::dropIfExists('historico_pessoas_turmas');
    }
}
