<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Anamneses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anamneses', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('possui_doenca')->nullable();
            $table->string('toma_medicacao')->nullable();
            $table->string('alergia_medicacao')->nullable();
            $table->float('peso')->nullable();
            $table->float('altura')->nullable();
            $table->string('fumante')->nullable();
            $table->string('cirurgia')->nullable();
            $table->string('dor_muscular')->nullable();
            $table->string('dor_ossea')->nullable();
            $table->string('dor_articular')->nullable();
            $table->string('atestado')->nullable();
            $table->string('observacao')->nullable();
            $table->integer('ano')->nullable();
            $table->unsignedInteger('pessoas_id')->nullable();
            $table->foreign('pessoas_id')->references('id')->on('pessoas')->onDelete('cascade');
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
        Schema::dropIfExists('anamneses');
    }
}
