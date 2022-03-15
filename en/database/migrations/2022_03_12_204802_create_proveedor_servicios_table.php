<?php

use App\Models\Servicio;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProveedorServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedor_servicios', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'id_usuario');
            $table->foreignIdFor(Servicio::class, 'id_servicio');
            $table->float('costo');
            $table->bigInteger('telefono');
            $table->string('nombre', 50);
            $table->text('pagina_web')->nullable();
            $table->text('ubicacion');
            $table->integer('es_fabricante')->nullable(false)->default(0);

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
        Schema::dropIfExists('proveedor_servicios');
    }
}
