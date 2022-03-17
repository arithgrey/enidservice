<?php

use App\Models\TipoValoracion;
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
            $table->string('slug')->unique();
            $table->text('comentario');
            $table->integer('calificacion');
            $table->integer('status')->nullable(false)->default(0);
            $table->integer('recomendaria');
            $table->string('titulo', 150);
            $table->string('email', 50);
            $table->string('nombre', 50);
            $table->string('imagen')->nullable();
            $table->integer('id_servicio');

            $table->foreignIdFor(TipoValoracion::class,'id_tipo_valoracion');
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
