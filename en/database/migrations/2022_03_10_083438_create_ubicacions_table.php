<?php

use App\Models\ProyectoPersonaFormaPago;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUbicacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ubicacions', function (Blueprint $table) {
            $table->id();
            $table->text('ubicacion');
            $table->string('status')->nullable(false)->default(1);
            $table->foreignIdFor(ProyectoPersonaFormaPago::class, 'id_recibo');
            $table->foreignIdFor(User::class, 'id_usuario');
            $table->integer('id_alcaldia')->nullable(false)->default(0);
            $table->string('cp')->nullable(false)->default(0);
            $table->string('delegacion', 45);
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
        Schema::dropIfExists('ubicacions');
    }
}
