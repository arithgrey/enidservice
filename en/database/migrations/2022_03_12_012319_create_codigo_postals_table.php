<?php

use App\Models\EstadoRepublica;
use App\Models\TipoAsentamiento;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCodigoPostalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codigo_postals', function (Blueprint $table) {
            $table->id();
            $table->string("cp", 45);
            $table->string("asentamiento", 200);
            $table->string("municipio", 200);
            $table->string("ciudad", 200);
            $table->string("estado", 200);
            $table->foreignIdFor(TipoAsentamiento::class, 'id_tipo_asentamiento');
            $table->foreignIdFor(EstadoRepublica::class, 'id_estado_republica');
            $table->string("pais", 55);
            $table->integer("id_pais")->nullable(false)->default(1);
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
        Schema::dropIfExists('codigo_postals');
    }
}
