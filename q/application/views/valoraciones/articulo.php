<?= get_title_valoraciones($id_usuario) ?>

<div class="col-lg-4 h-400 d-flex flex-column justify-content-center text-center">

    <?= div(anchor_enid("ESCRIBE UNA RESEÑA" . icon("fa fa-chevron-right ir"),
        [
            "class" => "escribir_valoracion",
            "href" => "../valoracion?servicio=" . $servicio,

        ]),
        ["class" => "btn_escribir_valoracion"]) ?>
    <?= crea_resumen_valoracion($numero_valoraciones); ?>

</div>
<div class="col-lg-8 ">

    <div class="col-lg-10 col-lg-offset-1">

        <?= get_td("", ["class" => "table_orden_1"]) ?>
        <div class="row mb-5">
            <?= div(heading_enid("ORDENAR POR" , 4), 4) ?>
            <?= div(get_criterios_busqueda(), 8) ?>
        </div>

        <?= get_btw(
            crea_resumen_valoracion_comentarios($comentarios, $respuesta_valorada),
            div(get_redactar_valoracion($comentarios, $numero_valoraciones, $servicio), ["class" => "btn_escribir_valoracion"]),
            "contenedor_comentarios"
        ) ?>
    </div>
</div>
