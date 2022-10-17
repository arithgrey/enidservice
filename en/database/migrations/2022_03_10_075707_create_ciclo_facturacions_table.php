<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCicloFacturacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ciclo_facturacions', function (Blueprint $table) {

            $table->id();
            $table->string("ciclo", 50);
            $table->integer("flag_meses")->nullable(false)->default(0);
            $table->integer("num_meses")->nullable(false)->default(0);
            $table->integer("status")->nullable(false)->default(1);

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
        Schema::dropIfExists('ciclo_facturacions');
    }
}
