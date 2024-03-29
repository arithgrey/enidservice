<?php

use App\Models\CuentaBanco;
use App\Models\User;
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

        Schema::create('solicitud_retiros', function (Blueprint $table) {
            $table->id();

            $table->float('monto');
            $table->integer('status')->nullable(false)->default(0);
            $table->foreignIdFor(User::class, 'user_id');
            $table->foreignIdFor(CuentaBanco::class, 'id_cuenta_banco');
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
