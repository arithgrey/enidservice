<?php
$recibo = $recibo[0];
$id_recibo = $recibo["id_proyecto_persona_forma_pago"];
$id_servicio = $recibo["id_servicio"];
$num_ciclos = $recibo["num_ciclos_contratados"];
$id_error = "imagen_" . $id_servicio;
$tipo_entrega  = $recibo["tipo_entrega"];

?>

<div class="top_50">
    <?= div(div(get_format_pre_orden($id_servicio, $id_error, $recibo, $domicilio, $id_recibo, $lista_direcciones), " padding_20 shadow" ), 5) ?>
    <?= get_btw(

        div(get_forms_domicilio_entrega($id_recibo, $lista_direcciones), 6)
        ,
        div(get_format_listado_puntos_encuentro($tipo_entrega,$puntos_encuentro, $id_recibo, $domicilio), 6)
        ,

        7
    ) ?>
</div>