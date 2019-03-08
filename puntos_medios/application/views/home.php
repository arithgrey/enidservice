<?= br(2) ?>
<?= get_format_identificacion($tipos_puntos_encuentro) ?>
<?= br() ?>
<?= div(place("place_lineas"), ["class" => "col-lg-8 col-lg-offset-2"], 1) ?>
<?php if ($primer_registro > 0): ?>
    <?= input_hidden(["name" => "servicio", "class" => "servicio", "value" => $servicio]) ?>
    <div class='formulario_quien_recibe display_none'>
        <?php if ($in_session < 1): ?>
            <div class="contenedor_eleccion_correo_electronico">
                <div class="col-lg-6 col-lg-offset-3">
                    <?= heading_enid("¿Quién recibe?", 2, ["class" => "strong"]) ?>
                    <div class="contendor_in_correo ">
                        <?= get_form_punto_encuentro($num_ciclos, $in_session, $servicio) ?>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="col-lg-6 col-lg-offset-3">
                <?= get_form_punto_encuentro_horario([
                    input_hidden(["name" => "punto_encuentro", "class" => "punto_encuentro_form", "value" => $punto_encuentro]),
                    input_hidden(["class" => "servicio", "name" => "servicio", "value" => $servicio]),
                    input_hidden(["name" => "num_ciclos", "class" => "num_ciclos", "value" => $num_ciclos])
                ]) ?>
            </div>
        <?php endif; ?>
    </div>
<?php else: ?>
    <?= get_form_quien_recibe($primer_registro, $punto_encuentro, $recibo) ?>
<?php endif; ?>
<?= input_hidden(["class" => "primer_registro", "value" => $primer_registro]) ?>