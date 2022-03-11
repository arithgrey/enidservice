<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Empresa;
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->foreignIdFor(Empresa::class, 'id_empresa')->nullable();
            $table->integer('status')->nullable(false)->default(1);
            $table->integer('sexo')->nullable(false)->default(0);
            $table->integer('tipo')->nullable(false)->default(1);

            $table->integer('id_usuario_referencia')->nullable(false)->default(0);
            $table->integer('num_compras')->nullable(false)->default(0);
            $table->integer('num_cancelaciones')->nullable(false)->default(0);
            $table->integer('ha_vendido')->nullable(false)->default(0);
            $table->integer('tiene_auto')->nullable(false)->default(0);
            $table->integer('tiene_moto')->nullable(false)->default(0);
            $table->integer('tiene_bicicleta')->nullable(false)->default(0);
            $table->integer('reparte_a_pie')->nullable(false)->default(0);
            $table->integer('puntuacion')->nullable(false)->default(0);
            $table->integer('orden_producto')->nullable(false)->default(0);
            $table->integer('idtipo_comisionista')->nullable(false)->default(1);

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
        Schema::dropIfExists('users');
    }
};
