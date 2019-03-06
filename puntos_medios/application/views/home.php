<?= br(2) ?>
<?= get_format_identificacion($tipos_puntos_encuentro) ?>
<?= br() ?>
<?= div(place("place_lineas"), ["class" => "col-lg-8 col-lg-offset-2"], 1) ?>
<?php if ($primer_registro > 0): ?>
    <?= input_hidden(["name" => "servicio", "class" => "servicio", "value" => $servicio]) ?>
    <div class='formulario_quien_recibe display_none'>
        <?= $this->load->view("quien_recibe"); ?>
    </div>
<?php else: ?>
    <?= get_form_quien_recibe($primer_registro, $punto_encuentro, $recibo) ?>
<?php endif; ?>
<?= input_hidden(["class" => "primer_registro", "value" => $primer_registro]) ?>