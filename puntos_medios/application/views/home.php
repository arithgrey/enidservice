<div class="row">
    <div class="col-lg-8 col-lg-offset-2">
        <?= get_format_identificacion($tipos_puntos_encuentro) ?>
        <?= div(div($leneas_metro, ["class" => "place_lineas col-lg-12"]), 2) ?>
        <?php if ($primer_registro > 0): ?>
            <?= input_hidden(["name" => "servicio", "class" => "servicio", "value" => $servicio]) ?>
            <div class='formulario_quien_recibe display_none'>
                <?php if ($in_session < 1): ?>
                    <?= div(get_btw(
                        "",
                        get_form_punto_encuentro($num_ciclos, $in_session, $servicio, $carro_compras, $id_carro_compras),
                        ""
                    ), ["class" => "contenedor_eleccion_correo_electronico"]) ?>

                <?php else: ?>

                    <?= div(get_form_punto_encuentro_horario([
                        input_hidden(["name" => "punto_encuentro", "class" => "punto_encuentro_form", "value" => $punto_encuentro]),
                        input_hidden(["class" => "servicio", "name" => "servicio", "value" => $servicio]),
                        input_hidden(["name" => "num_ciclos", "class" => "num_ciclos", "value" => $num_ciclos]),
                        input_hidden(["name" => "id_carro_compras", "class" => "id_carro_compras", "value" => $id_carro_compras]),
                        input_hidden(["name" => "carro_compras", "class" => "carro_compras", "value" => $carro_compras])

                    ]), 6, 1) ?>

                <?php endif; ?>
            </div>
        <?php else: ?>

            <?= get_form_quien_recibe($primer_registro, $punto_encuentro, $recibo) ?>
            <?= input_hidden(["class" => "recibo", "name" => "recibo", "value" => $recibo]) ?>

        <?php endif; ?>

        <?= input_hidden(["class" => "primer_registro", "value" => $primer_registro]) ?>

    </div>
</div>