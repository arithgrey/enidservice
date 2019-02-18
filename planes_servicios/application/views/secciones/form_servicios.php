<?php
$tipo_promocion_producto
    =
    anchor_enid('UN PRODUCTO',
        ["class" => "tipo_promocion tipo_producto easy_select_enid",
            "id" => "0",
            "style" => "color: blue;"]);

$tipo_promocion_servicio
    = anchor_enid(
    "UN SERVICIO",
    ["class" => "tipo_promocion tipo_servicio",
        "id" => "1"
    ]);


$t_tipo_promocion = heading_enid(
    icon('fa fa-shopping-bag') . "ARTÍCULO", "4",
    ['class' => 'text_modalidad',
        'title' => "¿Qué vendes?"
    ], 1
);

$t_ciclo_facturacion = heading_enid(
    "CICLO DE FACTURACIÓN",
    "4",
    [
        'title' => "¿Qué vendes?"
    ], 1);


$t_costo =
    heading_enid(
        icon('fa fa-money') . "PRECIO", "4",
        ['title' => "¿Cual es el precio de tu artículo/Servicio?"
        ], 1);


$i_tipo_promocion = input(
    [
        "id" => "nombre_producto",
        "name" => "nombre",
        "class" => "input  nuevo_producto_nombre input-sm",
        "type" => "text",
        "onkeyup" => "transforma_mayusculas(this)",
        "required" => true
    ], 1
);


$i_costo = input(
    [
        "id" => "costo",
        "class" => "form-control input-sm costo precio",
        "name" => "costo",
        "required" => true,
        "step" => "any",
        "type" => "number"
    ], 1
);
$s_ciclo_facturcion = create_select($ciclo_facturacion,
    "ciclo",
    "form-control ciclo_facturacion ci_facturacion",
    "ciclo",
    "ciclo",
    "id_ciclo_facturacion",
    1);


?>
<div class="contenedor_agregar_servicio_form">
    <?= heading_enid("DA A CONOCER TU PRODUCTO Ó SERVICIO", "2", ['class' => 'strong'], 1) ?>
    <hr>
    <?= form_open('', ['class' => "form_nombre_producto row", "id" => 'form_nombre_producto']) ?>
    <div class="col-lg-3 seccion_menu_tipo_servicio ">
        <?= div("¿QUÉ DESEAS ANUNCIAR?", ['class' => 'text_deseas_anunciar'], 1); ?>
        <?= br() ?>
        <table>
            <tr>
                <?= get_td($tipo_promocion_producto) ?>
                <?= get_td($tipo_promocion_servicio) ?>
            </tr>
        </table>
    </div>
    <?= div($t_tipo_promocion . $i_tipo_promocion, ["class" => "col-lg-3 seccion_menu_tipo_servicio"]) ?>
    <?= div($t_ciclo_facturacion . $s_ciclo_facturcion,
        [
            "class" => "col-lg-3 contenedor_ciclo_facturacion seccion_menu_tipo_servicio",
            "style" => "display: none;"
        ]) ?>
    <?= div(
        $t_costo . $i_costo . div($error_registro, ["class" => "extra_precio"], 1),
        ["class" => "col-lg-3 contenedor_precio seccion_menu_tipo_servicio"]
    ) ?>
    <?= div(
        guardar("SIGUIENTE", ["class" => "btn_siguiente_registrar_servicio "], 1),
        ["class" => 'seccion_menu_tipo_servicio col-lg-3 siguiente_btn']
    ); ?>
    <?= form_close() ?>
</div>
<?php if ($is_mobile == 1): ?>
    <?php $this->load->view("secciones/categorias_movil"); ?>
<?php else: ?>
    <?php $this->load->view("secciones/categorias_web"); ?>
<?php endif; ?>

