<?php

use App\Models\Banco;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuentaBancosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuenta_bancos', function (Blueprint $table) {
            $table->id();

            $table->text('tarjeta')->nullable(false);
            $table->integer('status')->nullable(false)->default(1);
            $table->string('propietario', 100);

            $table->foreignIdFor(User::class, 'user_id');
            $table->foreignIdFor(Banco::class, 'id_banco');




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
        Schema::dropIfExists('cuenta_bancos');
    }
}
