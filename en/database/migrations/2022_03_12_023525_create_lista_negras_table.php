<?php

use App\Models\MotivoListaNegra;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListaNegrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lista_negras', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class,  'id_usuario');
            $table->foreignIdFor(MotivoListaNegra::class, 'id_motivo');

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
        Schema::dropIfExists('lista_negras');
    }
}
