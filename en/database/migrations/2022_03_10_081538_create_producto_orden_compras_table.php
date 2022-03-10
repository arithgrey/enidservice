<?php

use App\Models\OrdenCompra;
use App\Models\ProyectoPersonaFormaPago;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoOrdenComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_orden_compras', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(ProyectoPersonaFormaPago::class, 'id_proyecto_persona_forma_pago');
            $table->foreignIdFor(OrdenCompra::class, 'id_orden_compra');

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
        Schema::dropIfExists('producto_orden_compras');
    }
}
