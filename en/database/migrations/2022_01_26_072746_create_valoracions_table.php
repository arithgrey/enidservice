<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValoracionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('valoracions', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            
            $table->unsignedBigInteger('user_id');            
            $table->string('slug')->unique();
            $table->text('comentario');
            $table->integer('calificacion');
            $table->integer('status')->nullable(false)->default(0);
            $table->integer('recomendaria');
            $table->string('titulo');
            $table->string('email');
            $table->string('nombre');
            $table->integer('id_servicio');            
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('valoracions');
    }
}
