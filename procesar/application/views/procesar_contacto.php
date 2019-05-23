<?= n_row_12() ?>
    <div class="col-lg-6 col-lg-offset-3">
        <?= place("info_articulo", ["id" => 'info_articulo']) ?>
        <div class="contenedor_compra">
            <div class="contenedo_compra_info">
                <?= validate_text_title($in_session, $is_mobile,1) ?>
                <?= get_form_contacto_servicio($in_session, $servicio) ?>
                <?= place("place_registro_afiliado") ?>
            </div>
        </div>
    </div>
<?= end_row() ?>