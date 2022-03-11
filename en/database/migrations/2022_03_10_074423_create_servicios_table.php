<?php

use App\Models\CicloFacturacion;
use App\Models\Clasificacion;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->foreignId('user_id')->nullable()->index();
            $table->text('description');
            $table->integer('status')->nullable(false)->default(1);
            $table->float('porcentaje_ganancia_venta')->nullable(false)->default(0);
            $table->text('url_web_servicio')->nullable();
            $table->float('porcentaje_ganancia_afiliado')->nullable(false)->default(0);

            $table->integer('flag_servicio')->nullable()->default(0);

            $table->integer('primer_nivel')->nullable()->default(0);
            $table->integer('segundo_nivel')->nullable()->default(0);
            $table->integer('tercer_nivel')->nullable()->default(0);
            $table->integer('cuarto_nivel')->nullable()->default(0);
            $table->integer('quinto_nivel')->nullable()->default(0);

            $table->integer('flag_envio_gratis')->nullable()->default(0);
            $table->integer('flag_precio_definido')->nullable()->default(1);
            $table->integer('flag_nuevo')->nullable()->default(1);
            $table->integer('flag_imagen')->nullable()->default(1);

            $table->text('url_vide_youtube')->nullable();
            $table->text('url_video_facebook')->nullable();

            $table->text('metakeyword')->nullable();
            $table->text('metakeyword_usuario')->nullable();

            $table->text('color')->nullable();
            $table->text('colores')->nullable();

            $table->float('precio')->nullable(false)->default(0);

            $table->foreignIdFor(Clasificacion::class, 'id_clasificacion');
            $table->foreignIdFor(User::class, 'id_usuario');
            $table->foreignIdFor(CicloFacturacion::class, 'id_ciclo_facturacion');
            $table->float('vista')->nullable(false)->default(0);

            $table->float('entregas_en_casa')->nullable(false)->default(0);
            $table->float('valoracion')->nullable(false)->default(0);
            $table->float('telefono_visible')->nullable(false)->default(0);
            $table->float('venta_mayoreo')->nullable(false)->default(0);

            $table->float('deseado')->nullable(false)->default(3);
            $table->float('tiempo_promedio_entrega')->nullable(false)->default(3);
            $table->text('talla')->nullable();
            $table->text('url_ml')->nullable();

            $table->integer('tipo_entrega_envio')->nullable(false)->default(0);
            $table->integer('tipo_entrega_visita')->nullable(false)->default(0);
            $table->integer('tipo_entrega_punto_medio')->nullable(false)->default(0);

            $table->text('link_dropshipping')->nullable();
            $table->integer('stock')->nullable(false)->default(0);
            $table->integer('contra_entrega')->nullable(false)->default(1);

            //$table->timestamp('fecha_servicio');

            $table->integer('aplica_cupon')->nullable(false)->default(1);
            $table->float('cupon_primer_compra')->nullable(false)->default(100);

            $table->integer('es_publico')->nullable(false)->default(1);
            $table->integer('comision')->nullable(false)->default(0);
            $table->integer('muestra_fecha_disponible')->nullable(false)->default(0);

            //$table->timestamp('fecha_disponible');
            $table->integer('es_posible_punto_encuentro')->nullable(false)->default(1);

            $table->integer('requiere_auto')->nullable(false)->default(0);
            $table->integer('moto')->nullable(false)->default(0);
            $table->integer('bicicleta')->nullable(false)->default(0);
            $table->integer('pie')->nullable(false)->default(0);
            $table->integer('solo_metro')->nullable(false)->default(0);

            $table->text('marca')->nullable();
            $table->text('material')->nullable();
            $table->string('dimension', 45)->nullable();

            $table->float('peso')->nullable(false)->default(0);
            $table->float('capacidad')->nullable(false)->default(0);
            $table->text('modelo')->nullable();
            $table->float('costo')->nullable(false)->default(0);
            $table->integer('descuento_especial')->nullable(false)->default(0);

            $table->text('link_amazon')->nullable();
            $table->text('link_ml')->nullable();


            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('servicios');
    }
}
