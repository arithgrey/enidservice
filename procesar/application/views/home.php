<div class='col-lg-8 col-lg-offset-2'>
    <?= place("info_articulo", ["id" => 'info_articulo']) ?>
    <?php

    $producto =
        create_resumen_servicio($servicio, $info_solicitud_extra);
    $ciclos_solicitados = $info_solicitud_extra["num_ciclos"];
    $resumen_producto = $producto["resumen_producto"];
    $resumen_servicio_info = $producto["resumen_servicio_info"];
    $monto_total = floatval($servicio[0]["precio"]) * floatval($ciclos_solicitados);

    $costo_envio_cliente = 0;
    $text_envio = "";
    if ($servicio[0]["flag_servicio"] == 0) {
        $costo_envio_cliente = $costo_envio["costo_envio_cliente"];
        $text_envio = $costo_envio["text_envio"]["cliente"];
    }

    $monto_total_con_envio = $monto_total + $costo_envio_cliente;
    ?>
    <div class="contenedor_compra">
        <div class="contenedo_compra_info">
            <div class="col-lg-10 col-lg-offset-1">

                    <?= get_format_resumen($resumen_producto, $text_envio, $resumen_servicio_info, $monto_total, $costo_envio_cliente, $monto_total_con_envio, $in_session) ?>

                <div class="contenedor_formulario_compra">
                    <?php
                    $info_ext = $info_solicitud_extra;
                    $plan = $info_ext["plan"];
                    $num_ciclos = $info_ext["num_ciclos"];
                    $ciclo_facturacion = $info_ext["ciclo_facturacion"];
                    $ingresar = anchor_enid('INGRESA', array(
                        'href' => '../login'
                    ));
                    $talla = (array_key_exists("talla", $info_solicitud_extra)) ? $info_solicitud_extra["talla"] : 0;

                    ?>
                    <?= validate_text_title($in_session, $is_mobile) ?>
                    <?= form_open("", ["class" => "form-miembro-enid-service", "id" => "form-miembro-enid-service"]) ?>
                    <?= get_form_miembro_enid_service_hidden($q2, $plan, $num_ciclos, $ciclo_facturacion, $talla) ?>
                    <?= get_format_form_primer_registro($in_session, $is_mobile, $info_ext) ?>
                    <?= place("place_registro_afiliado") ?>
                </div>
            </div>
            <?= hr() ?>
        </div>
        <?= input_hidden(["value" => $email, "class" => 'email_s']) ?>


