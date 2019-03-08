<?= get_title_valoraciones($id_usuario) ?>
<?= hr() ?>
<table style="width: 100%">
    <tr>
        <?= get_td("", ["class" => "table_orden_1"]) ?>
        <td class="table_orden_2">
            <?= strong("ORDENAR POR") ?>
        </td>
        <td class="table_orden_3">
            <table border="1">
                <tr>
                    <?= get_criterios_busqueda() ?>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?= hr() ?>
<div class="col-lg-4">
    <?= div(anchor_enid("ESCRIBE UNA RESEÑA" . icon("fa fa-chevron-right ir"),
        [
            "class" => "escribir_valoracion",
            "href" => "../valoracion?servicio=" . $servicio,

        ]),
        ["class" => "btn_escribir_valoracion"]) ?>
    <?= crea_resumen_valoracion($numero_valoraciones); ?>
</div>
<div class="col-lg-8">
    <div class="contenedor_comentarios">
        <?= crea_resumen_valoracion_comentarios($comentarios, $respuesta_valorada); ?>
        <?= div(get_redactar_valoracion($comentarios, $numero_valoraciones, $servicio), ["class" => "btn_escribir_valoracion"]) ?>
    </div>
</div>
