<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudRetirosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('solicitud_retiros');
        Schema::create('solicitud_retiros', function (Blueprint $table) {
            $table->id();

            $table->float('monto');
            $table->integer('status')->nullable(false)->default(0);


            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            //$table->foreignIdFor(CuentaPago::class,'id_cuenta_pago');

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
        Schema::dropIfExists('solicitud_retiros');
    }
}
