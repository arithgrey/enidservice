<?php
$en_servicios = [];
$en_productos = [];
$id_servicio = "";
$nombre_servicio = "";
$status = "";
$url_vide_youtube = "";
$url_video_facebook = "";
$url_productos_publico = "";
$metakeyword = "";
$metakeyword_usuario = "";
$flag_nuevo = 0;
$flag_envio_gratis = 0;
$flag_servicio = 0;
$existencia = 0;
$color = "";
$precio = 0;
$id_ciclo_facturacion = 0;
$entregas_en_casa = 0;
$telefono_visible = 0;
$venta_mayoreo = 0;
$url_ml = "";
$link_dropshipping = "";
$stock = 0;
$contra_entrega = 0;
foreach ($servicio as $row) {

    $id_servicio = $row["id_servicio"];
    $nombre_servicio = $row["nombre_servicio"];
    $param["nombre_servicio"] = $nombre_servicio;
    $status = $row["status"];
    $url_vide_youtube = $row["url_vide_youtube"];
    $url_video_facebook = $row["url_video_facebook"];
    $metakeyword = $row["metakeyword"];
    $metakeyword_usuario = $row["metakeyword_usuario"];
    $flag_nuevo = $row["flag_nuevo"];
    $flag_envio_gratis = $row["flag_envio_gratis"];
    $flag_servicio = $row["flag_servicio"];
    $existencia = $row["existencia"];
    $color = $row["color"];
    $precio = $row["precio"];
    $id_ciclo_facturacion = $row["id_ciclo_facturacion"];
    $entregas_en_casa = $row["entregas_en_casa"];
    $telefono_visible = $row["telefono_visible"];
    $venta_mayoreo = $row["venta_mayoreo"];
    $tiempo_promedio_entrega = $row["tiempo_promedio_entrega"];
    $url_ml = $row["url_ml"];
    $link_dropshipping = $row["link_dropshipping"];
    $stock = $row["stock"];
    $contra_entrega = $row["contra_entrega"];


}

$url_web_servicio = $url_request . "producto/?producto=" . $id_servicio;
$url_productos_publico = "../producto/?producto=" . $id_servicio . "&q2=" . $id_usuario;
/*INFO costoS SERVICIO */
$costo_envio_vendedor =
    ($flag_servicio == 0) ? floatval($costo_envio["costo_envio_vendedor"]) : 0;

$comision = 0;
$utilidad = 0;
if ($flag_servicio == 0) {

    $comision = porcentaje(floatval($precio), $porcentaje_comision);
    $comision_num = porcentaje(floatval($precio), $porcentaje_comision, 2, 2);
    $utilidad = floatval($precio) - $costo_envio_vendedor;
    $utilidad = $utilidad - $comision_num;


}

$param["precio"] = $precio;
$ganancias_afiliados = 0;
$ganancias_vendedores = 0;
$text_meses = "No aplica";
$text_num_mensualidades = "No aplica";


$info_colores = create_colores_disponibles($color);
$en_productos["flag_nuevo"] = $flag_nuevo;
$en_productos["existencia"] = $existencia;


$en_servicios["id_ciclo_facturacion"] = $id_ciclo_facturacion;

$text_clasificacion = "";
foreach ($clasificaciones as $row) {
    $id_clasificacion = $row["id_clasificacion"];
    $nombre_clasificacion = $row["nombre_clasificacion"];
    $text_clasificacion .= $nombre_clasificacion . " /";
}
$data["tipo_promocion"] = $tipo_promocion = valida_tipo_promocion($servicio);
$data["servicio"] = $servicio;
$data["url_productos_publico"] = $url_productos_publico;
$data["precio"] = $precio;
$data["utilidad"] = $utilidad;
$data["comision"] = $comision;
$data["url_ml"] = $url_ml;


$data["flag_servicio"] = get_campo($servicio, "flag_servicio");


$notificacion_imagenes = heading_enid(valida_text_imagenes($tipo_promocion, $num_imagenes), 3);
$extra_extrega_casa_no = val_class(0, $entregas_en_casa , "button_enid_eleccion_active");
$activo_visita_telefono = val_class(1, $telefono_visible , "button_enid_eleccion_active");
$baja_visita_telefono = val_class(0, $telefono_visible, "button_enid_eleccion_active");
$data["venta_mayoreo"] = $venta_mayoreo;


$extra_1 = val_class($num, 1, ' active ');
$extra_2 = val_class($num, 2, ' active ');
$extra_3 = val_class($num, 3, ' active ');
$extra_4 = val_class($num, 4, ' active ');


$text_llamada_accion_youtube = icon('fa fa-youtube-play') . " VIDEO DE YOUTUBE ";
$valor_youtube = get_campo($servicio, "url_vide_youtube");
$val_youtube = icon('fa fa-pencil text_url_youtube') . $valor_youtube;
$nuevo_nombre_servicio = get_campo($servicio, "nombre_servicio");

$text_titulo_seccion_producto = heading_enid("INFORMACIÓN SOBRE TU " . $nuevo_nombre_servicio . icon('fa fa-pencil text_desc_servicio icon-pencil') , 5);
$nueva_descripcion = get_campo($servicio, 'descripcion');



$nuevo_titulo_seleccion_producto = div($text_titulo_seccion_producto, "top_50 titulo_seccion_producto titulo_producto_servicio", 1);
$info_nueva_descripcion = div($nueva_descripcion, "text_desc_servicio contenedor_descripcion top_30", 1);

$text_comision_venta = "COMISIÓN POR VENTA" . $comision . "MXN";
$text_envios_mayoreo = "¿TAMBIÉN VENDES ESTE PRODUCTO A PRECIOS DE MAYOREO?";

?>
<?= agregar_imgs() ?>
<div class="contenedor_global_servicio">

    <?= get_heading_servicio($tipo_promocion, $nuevo_nombre_servicio, $servicio) ?>
    <?= addNRow(get_menu_config($num, $num_imagenes, $url_productos_publico)) ?>
    <div class="tab-content">
        <div class="tab-pane <?= $extra_1 ?>" id="tab_imagenes">
            <?= addNRow($notificacion_imagenes); ?>
            <?= addNRow(valida_descartar_promocion($num_imagenes, $id_servicio, $id_perfil)) ?>
            <?= div($images, ["class" => "contenedor_imagen_muestra"], 1) ?>
            <?= heading_enid("¿TIENES ALGÚN VIDEO SOBRE TU " . $tipo_promocion . "?", 4) ?>
            <?= div($text_llamada_accion_youtube, 1) ?>
            <?= div($val_youtube, ["class" => "text_video_servicio"], 1) ?>
            <?= get_form_youtube($valor_youtube) ?>
        </div>
        <!--DESCRIPCION DEL PRODUCTO-->
        <div class="tab-pane <?= $extra_2 ?>" id="tab_info_producto">

            <?= $nuevo_titulo_seleccion_producto; ?>
            <?= place("place_tallas_disponibles") ?>
            <?= $info_nueva_descripcion ?>
            <?= get_form_descripcion($nueva_descripcion); ?>
            <?=get_format_colores($flag_servicio,$info_colores)?>

        </div>
        <div class="tab-pane <?= $extra_4 ?>" id="tab_info_precios">

            <?= div(div(get_estado_publicacion($status, $id_servicio), "col-lg-4 top_30 bottom_20", 1), 12) ?>
            <?= get_form_rango_entrega($flag_servicio , $id_perfil , $stock) ?>
            <?= div(get_rango_entrega(
                    $id_perfil,
                    $tiempo_promedio_entrega,
                    [
                        "name" => "tiempo_entrega"
                        ,
                        "class" => "tiempo_entrega form-control"
                    ],
                    "DÍAS PROMEDIO DE ENTREGA")
                ,
                6
            ) ?>
            <?= div(
                get_form_link_drop_shipping($id_perfil, $id_servicio, $link_dropshipping)
                ,
                6
            ) ?>


            <?= div(get_seccion_compras_casa($flag_servicio, $entregas_en_casa), 6) ?>
            <?= div(get_seccion_telefono_publico($has_phone, $telefono_visible, $activo_visita_telefono, $baja_visita_telefono, $flag_servicio), 6) ?>
            <?= get_configuracion_contra_entrega($flag_servicio, $contra_entrega, $id_servicio) ?>
            <?= get_seccion_uso_disponibilidad($existencia,$flag_nuevo, $flag_servicio)?>
            <?= get_seccion_ciclos_facturacion($ciclos, $id_ciclo_facturacion, $flag_servicio) ?>
            <?= get_format_venta_mayoreo($flag_servicio , $text_envios_mayoreo, $venta_mayoreo)?>
            <?= get_format_enlace_venta_extra($flag_servicio,$url_ml)?>
            <?= get_form_costo_unidad($precio,$flag_servicio,$costo_envio) ?>
            <?= get_format_utilidad($flag_servicio,$text_comision_venta, $utilidad )?>



        </div>
        <?= div(get_form_tags($id_servicio, $metakeyword_usuario), ["class" => "tab-pane " . $extra_3, "id" => "tab_terminos_de_busqueda"]) ?>
    </div>
</div>