<?php

use App\Models\CicloFacturacion;
use App\Models\FormaPago;
use App\Models\Servicio;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectoPersonaFormaPagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyecto_persona_forma_pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(FormaPago::class, 'id_forma_pago');

            $table->float('saldo_cubierto')->nullable(false)->default(0);
            $table->integer('status')->nullable(false)->default(1);
            //fecha_vencimiento
            $table->float('monto_a_pagar')->nullable(false)->default(0);

            $table->integer('num_email_recordatorio')->nullable(false)->default(0);
            $table->integer('id_usuario_referencia')->nullable(false)->default(0);
            $table->integer('flag_pago_comision')->nullable(false)->default(0);
            $table->integer('flag_envio_gratis')->nullable(false)->default(0);
            $table->float('costo_envio_cliente')->nullable(false)->default(0);
            $table->float('id_usuario_venta')->nullable();

            $table->foreignIdFor(CicloFacturacion::class, 'id_ciclo_facturacion');

            $table->integer('num_ciclos_contratados')->nullable(false)->default(0);

            $table->foreignIdFor(User::class, 'id_usuario');

            $table->float('precio')->nullable(false)->default(0);
            $table->float('costo_envio_vendedor')->nullable(false)->default(0);

            $table->foreignIdFor(Servicio::class, 'id_servicio');

            $table->text('resumen_pedido')->nullable();
            $table->integer('estado_envio')->nullable(false)->default(0);
            $table->integer('entregado')->nullable(false)->default(0);

            //fecha_entrega
            //fecha_pago
            //fecha_cancelacion

            $table->integer('cancela_cliente')->nullable(false)->default(0);
            $table->integer('se_cancela')->nullable(false)->default(0);
            $table->integer('cancela_email')->nullable(false)->default(0);
            $table->integer('talla')->nullable(false)->default(0);
            $table->text('nota')->nullable();

            //fecha_contra_entrega
            $table->integer('tipo_entrega')->nullable(false)->default(2);

            $table->integer('modificacion_fecha')->nullable(false)->default(0);
            $table->integer('notificacion_encuesta')->nullable(false)->default(0);
            $table->integer('fecha_servicio')->nullable(false)->default(0);

            $table->float('comision_venta')->nullable(false)->default(0);
            $table->integer('intento_reventa')->nullable(false)->default(0);
            $table->integer('intento_recuperacion')->nullable(false)->default(0);
            $table->integer('es_test')->nullable(false)->default(0);

            $table->integer('id_usuario_entrega')->nullable(false)->default(0);

            $table->integer('efectivo_en_casa')->nullable(false)->default(0);
            $table->integer('registro_articulo_interes')->nullable(false)->default(0);
            $table->integer('contra_entrega_domicilio')->nullable(false)->default(0);
            $table->integer('ubicacion')->nullable(false)->default(0);
            $table->integer('total_like')->nullable(false)->default(0);

            $table->integer('costo')->nullable(false)->default(0);
            $table->integer('descuento_premium')->nullable(false)->default(0);

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
        Schema::dropIfExists('proyecto_persona_forma_pagos');
    }
}
