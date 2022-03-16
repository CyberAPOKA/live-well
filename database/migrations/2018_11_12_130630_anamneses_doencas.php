<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AnamnesesDoencas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anamneses_doencas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('anamnese_id')->nullable();
            $table->unsignedInteger('doenca_id')->nullable();
            $table->foreign('anamnese_id')->references('id')->on('anamneses')->onDelete('set null');
            $table->foreign('doenca_id')->references('id')->on('doencas')->onDelete('set null');
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
        Schema::dropIfExists('anamneses_doencas');
    }
}
