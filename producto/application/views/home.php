<?php

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
    $contra_entrega = $row["contra_entrega"];

}

$imagenes = construye_seccion_imagen_lateral($imgs, $nombre_servicio, $url_vide_youtube);
$vendedor_valoracion = anchor_enid("", ['class' => 'valoracion_persona_principal valoracion_persona']);
$nombre_servicio = substr(strtoupper($nombre_servicio), 0, 70);
$nombre_producto = heading_enid($nombre_servicio, 1, ['class' => "strong"]);
$nuevo_nombre_servicio = valida_text_servicio($flag_servicio, $precio, $id_ciclo_facturacion);
$boton_editar = valida_editar_servicio($id_usuario_servicio, $id_usuario, $in_session, $id_servicio);
$texto_en_existencia = get_text_diponibilidad_articulo($existencia, $flag_servicio, $url_ml);


$estrellas = anchor_enid(div("", ['class' => 'valoracion_persona_principal valoracion_persona']), ['class' => 'lee_valoraciones', 'href' => '../search/?q3=' . $id_publicador]);


?>

    <div class="product-detail contenedor_info_producto">
        <div class="col-lg-8">
            <div class="col-lg-8">
                <div class="left-col contenedor_izquierdo">
                    <?= div($imagenes["preview"], ["class" => "thumbs"]) ?>
                    <?= div(div($imagenes["imagenes_contenido"], ["class" => "tab-content"]), ["class" => "big"]) ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="contenedor_central_info">
                    <?= get_contenedor_central($proceso_compra, $id_servicio, $tiempo_entrega, $color, $flag_servicio, $flag_nuevo, $usuario, $id_publicador, $url_actual, $desc_web) ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <?php if ($flag_servicio < 1): ?>
                <?php if ($existencia > 0): ?>

                    <div class="info-venta">
                        <?= get_format_venta_producto($boton_editar, $estrellas, $nombre_producto, $nuevo_nombre_servicio,
                            $flag_servicio, $existencia, $id_servicio, $in_session, $q2, $precio, $id_ciclo_facturacion, $tallas, $texto_en_existencia, $entregas_en_casa, $proceso_compra,
                            $telefono_visible, $usuario, $venta_mayoreo) ?>
                    </div>
                <?php else: ?>
                    <?= get_format_no_visible($nombre_producto, $precio, $existencia, $flag_servicio, $url_ml, $id_servicio) ?>
                <?php endif; ?>

            <?php else: ?>
                <div class="card box-shadow">
                    <?= div(heading_enid(substr(strtoupper($nombre_servicio), 0, 70), 1), ["class" => "card-header"]) ?>
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
                    <?= validate_form_compra($flag_servicio, $existencia, $id_servicio, $in_session, $q2, $precio, $id_ciclo_facturacion) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

<?= addNRow(div(get_descripcion_servicio($descripcion, $flag_servicio), ["class" => "col-lg-10 col-lg-offset-1"])) ?>
<?= div("", ["id" => "video"]) ?>
<?= addNRow(div(valida_url_youtube($url_vide_youtube, $is_mobile), ["class" => "col-lg-10 col-lg-offset-1"])) ?>
<?= br(2) ?>
<?= addNRow(place("separador")) ?>
<?= br(2) ?>
<?= addNRow(div(place("place_valoraciones"), ["class" => "col-lg-10 col-lg-offset-1", "style" => "background: white;"]), ["style" => "background: #002693;"]) ?>
<?= br(4) ?>
<?= addNRow(div(place("place_tambien_podria_interezar"), ["class" => "col-lg-10 col-lg-offset-1", "style" => "background: white;"])) ?>
<?= input_hidden(["class" => "qservicio", "value" => $nombre_servicio]) ?>
<?= input_hidden(["name" => "servicio", "class" => "servicio", "value" => $id_servicio]) ?>
<?= input_hidden(["name" => "desde_valoracion", "value" => $desde_valoracion, "class" => 'desde_valoracion']) ?>