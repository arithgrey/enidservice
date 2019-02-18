<?php

    $info_social["url_facebook"] = get_url_facebook($url_actual);
    $info_social["url_twitter"] = get_url_twitter($url_actual, $desc_web);
    $info_social["url_pinterest"] = get_url_pinterest($url_actual, $desc_web);
    $info_social["url_tumblr"] = get_url_tumblr($url_actual, $desc_web);
    $url_vide_youtube = "";
    $id_servicio = "";
    $nombre_servicio = "";
    $descripcion = "";
    $status = "";
    $id_clasificacion = "";
    $flag_servicio = "";
    $flag_envio_gratis = "";
    $flag_precio_definido = "";
    $flag_nuevo = "";
    $existencia = 0;
    $color = "";
    $precio = 0;
    $id_usuario_servicio = 0;
    $entregas_en_casa = 0;
    $telefono_visible = 0;
    $venta_mayoreo = 0;
    $url_ml = "";
    foreach ($info_servicio["servicio"] as $row) {

        $id_servicio = $row["id_servicio"];
        $nombre_servicio = $row["nombre_servicio"];
        $descripcion = $row["descripcion"];
        $status = $row["status"];
        $id_clasificacion = $row["id_clasificacion"];
        $flag_servicio = $row["flag_servicio"];
        $flag_envio_gratis = $row["flag_envio_gratis"];
        $flag_precio_definido = $row["flag_precio_definido"];
        $flag_nuevo = $row["flag_nuevo"];
        $url_vide_youtube = $row["url_vide_youtube"];
        $existencia = $row["existencia"];
        $color = $row["color"];
        $flag_precio_definido = $row["flag_precio_definido"];
        $precio = $row["precio"];
        $id_ciclo_facturacion = $row["id_ciclo_facturacion"];
        $entregas_en_casa = $row["entregas_en_casa"];
        $id_usuario_servicio = $row["id_usuario"];
        $telefono_visible = $row["telefono_visible"];
        $venta_mayoreo = $row["venta_mayoreo"];
        $url_ml = $row["url_ml"];

    }


    $imagenes                   = construye_seccion_imagen_lateral($imgs, $nombre_servicio, $url_vide_youtube);
    $info_compra["id_servicio"] = $id_servicio;
    $info_compra["proceso_compra"] = $proceso_compra;
    $info_compra["flag_servicio"] = $flag_servicio;
    $info_compra["precio"] = $precio;
    $info_compra["id_ciclo_facturacion"] = $id_ciclo_facturacion;
    $url_tienda = '../search/?q3=' . $id_publicador;
    $vendedor_valoracion = anchor_enid("", ['class' => 'valoracion_persona_principal valoracion_persona']);
    $nombre_servicio = substr(strtoupper($nombre_servicio), 0, 70);
    $nombre_producto = heading_enid($nombre_servicio, 1, ['class' => "strong"]);
    $nuevo_nombre_servicio = valida_text_servicio($flag_servicio, $precio, $id_ciclo_facturacion);
    $boton_editar = valida_editar_servicio($id_usuario_servicio, $id_usuario, $in_session, $id_servicio);
    $texto_en_existencia = get_text_diponibilidad_articulo($existencia, $flag_servicio, $url_ml);
    $config = ['class' => 'valoracion_persona_principal valoracion_persona'];
    $estrellas = anchor_enid(div("", $config), ['class' => 'lee_valoraciones', 'href' => $url_tienda]);


?>
<?= n_row_12() ?>
    <div class="product-detail contenedor_info_producto">
        <div class="col-lg-8">
            <div class="col-lg-8">
                <div class="row">
                    <?= n_row_12() ?>
                    <div class="left-col contenedor_izquierdo">
                        <?= div($imagenes["preview"], ["class" => "thumbs"]) ?>
                        <?= div(div($imagenes["imagenes_contenido"], ["class" => "tab-content"]), ["class" => "big"]) ?>
                    </div>
                    <?= end_row() ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="row">
                    <div class="contenedor_central_info">
                        <?= get_solicitud_informacion($proceso_compra, $id_servicio) ?>
                        <?php if ($proceso_compra == 1): ?>
                            <?= get_tiempo_entrega(0, $tiempo_entrega) ?>
                        <?php endif; ?>
                        <?= creta_tabla_colores($color, $flag_servicio) ?>
                        <?= place("separador") ?>
                        <?= div(valida_informacion_precio_mayoreo($flag_servicio, $venta_mayoreo), 1) ?>
                        <?= div(get_tipo_articulo($flag_nuevo, $flag_servicio), 1) ?>
                        <?= place("separador") ?>
                        <?= get_nombre_vendedor($proceso_compra, $usuario, $id_publicador) ?>
                        <?= n_row_12() ?>
                        <?= div(get_entrega_en_casa($entregas_en_casa, $flag_servicio), ['class' => 'strong']) ?>
                        <?= get_contacto_cliente($proceso_compra, $telefono_visible, $in_session, $usuario) ?>
                        <?= end_row() ?>
                        <?= place("separador") ?>
                        <?= get_tiempo_entrega($proceso_compra, $tiempo_entrega) ?>
                        <?php if ($proceso_compra == 0): ?>
                            <?=br()?>
                            <?= n_row_12() ?>
                            <?= $this->load->view("social", $info_social) ?>
                            <?= end_row() ?>
                        <?php endif; ?>
                        <?=br()?>
                        <?= get_tienda_vendedor($proceso_compra, $id_publicador) ?>
                        <?= place("", ["style" => "border: solid 1px"]) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <?php if ($flag_servicio == 0): ?>
                <?php if ($existencia > 0): ?>
                    <?= n_row_12() ?>
                    <div class="info-venta">
                        <?= $boton_editar ?>
                        <?= $estrellas ?>
                        <?= $nombre_producto ?>
                        <?= heading_enid($nuevo_nombre_servicio, 3) ?>
                        <?= get_text_costo_envio($flag_servicio, $costo_envio) ?>
                        <?= $this->load->view("form_compra", $info_compra) ?>
                        <?= $tallas ?>
                        <?= $texto_en_existencia ?>
                    </div>
                    <?= end_row() ?>

                <?php else: ?>
                    <div class="card box-shadow">
                        <?= div($nombre_producto, ["class" => "card-header"]) ?>
                        <div class="card-body">
                            <?= heading($precio . "MXN" . get_text_diponibilidad_articulo($existencia, $flag_servicio, $url_ml),
                                1,
                                ["class" => "card-title pricing-card-title"]
                            ) ?>

                            <?=ul([
                                "Artículo temporalmente agotado",
                                anchor_enid(
                                    "Preguntar cuando estará disponible",
                                    ["href" => "../pregunta/?tag=<?=$id_servicio?>&disponible=1"],
                                    1,
                                    1
                                )

                            ],
                                ["class"=>"list-unstyled mt-3 mb-4"])?>
                        </div>
                    </div>
                <?php endif; ?>

            <?php else: ?>

                <div class="card box-shadow">
                    <?= div(heading_enid(substr(strtoupper($nombre_servicio), 0, 70), 1),
                        ["class" => "card-header"]
                    ) ?>
                    <?= heading_enid(
                        valida_text_servicio(
                            $flag_servicio,
                            $precio,
                            $id_ciclo_facturacion),
                        3,
                        ["class" => 'card-title pricing-card-title']
                    ) ?>
                    <?= anchor_enid(
                        "Pedir más información",
                        ["href" => "../pregunta/?tag=" . $id_servicio . "?>&disponible=1"
                        ]
                    ) ?>
                    <?= $this->load->view("form_compra", $info_compra) ?>
                </div>
            <?php endif; ?>
        </div>

    </div>
<?= end_row() ?>
<?=addNRow(div(get_descripcion_servicio($descripcion, $flag_servicio) , ["class" => "col-lg-10 col-lg-offset-1"])) ?>
<?=addNRow(div(valida_url_youtube($url_vide_youtube, $is_mobile) , ["class" => "col-lg-10 col-lg-offset-1"])) ?>
<?=br(2)?>
<?=addNRow(place("separador"))?>
<?=br(2)?>
<?=addNRow(div(place("place_valoraciones") , ["class" => "col-lg-10 col-lg-offset-1" , "style"=>"background: white;"]) , ["style"=> "background: #002693;"]) ?>
<?=br(4)?>
<?=addNRow(div(place("place_tambien_podria_interezar") , ["class" => "col-lg-10 col-lg-offset-1" , "style"=>"background: white;"]))?>
<?= input_hidden(["class" => "qservicio", "value" => $nombre_servicio]) ?>
<?= input_hidden(["name" => "servicio", "class" => "servicio", "value" => $id_servicio]) ?>
<?= input_hidden(["name" => "desde_valoracion", "value" => $desde_valoracion, "class" => 'desde_valoracion']) ?>