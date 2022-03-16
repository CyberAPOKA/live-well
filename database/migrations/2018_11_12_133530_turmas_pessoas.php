<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TurmasPessoas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turmas_pessoas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('turma_id')->nullable();
            $table->unsignedInteger('pessoa_id')->nullable();
            $table->integer('inativo')->nullable();
            $table->foreign('turma_id')->references('id')->on('turmas')->onDelete('set null');
            $table->foreign('pessoa_id')->references('id')->on('pessoas')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('turmas_pessoas');
    }
}
