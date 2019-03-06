<?php if ($in_session < 1): ?>
    <div class="contenedor_eleccion_correo_electronico">
        <div class="col-lg-6 col-lg-offset-3">
            <?= heading_enid("¿Quién recibe?", 2, ["class" => "strong"]) ?>
            <div class="contendor_in_correo ">
                <?= form_open("", ["class" => "form-horizontal form_punto_encuentro"]) ?>
                <?= label(" NOMBRE ", ["class" => "col-lg-3 "]) ?>
                <?= div(input([
                    "id" => "nombre",
                    "name" => "nombre",
                    "type" => "text",
                    "placeholder" => "Persona que recibe",
                    "class" => "form-control input-md nombre",
                    "required" => true
                ]), ["class" => "col-lg-9"]) ?>

                <?= label("CORREO ", ["class" => "col-lg-3 "]) ?>
                <?= div(input([
                    "id" => "correo",
                    "name" => "email",
                    "type" => "email",
                    "placeholder" => "@",
                    "class" => "form-control input-md correo",
                    "required" => true
                ]), ["class" => "col-lg-9"]) ?>

                <?= label(" TELÉFONO ", ["class" => "col-lg-3 "]) ?>
                <?= div(input([
                    "id" => "tel",
                    "name" => "telefono",
                    "type" => "tel",
                    "class" => "form-control input-md  telefono",
                    "required" => true
                ]), ["class" => "col-lg-9"]) ?>

                <?= label(" CONTRASEÑA", ["class" => "col-lg-3 "]) ?>

                <?= div(input([
                    "id" => "pw",
                    "name" => "password",
                    "type" => "password",
                    "class" => "form-control input-md  pw",
                    "required" => true
                ]), ["class" => "col-lg-9"]) ?>

                <?= br(2) ?>
                <?= div(heading_enid("¿En qué horario te gustaría recibir tu pedido?",
                    4,
                    ["class" => "strong pull-right"]), ["class" => "col-lg-12"]) ?>

                <?= label(icon("fa fa-calendar-o") . " FECHA ", ["class" => "col-lg-2 "]) ?>

                <?= div(input(
                    [
                        "data-date-format" => "yyyy-mm-dd",
                        "name" => 'fecha_entrega',
                        "class" => "form-control input-sm ",
                        "type" => 'date',
                        "value" => date("Y-m-d"),
                        "min" => date("Y-m-d"),
                        "max" => add_date(date("Y-m-d"), 4)
                    ]), ["class" => "col-lg-8"]) ?>

                <?= label(icon("fa fa-clock-o") . " HORA DE ENCUENTRO",
                    ["class" => "col-lg-4 "]
                ) ?>
                <?= div(lista_horarios(), ["class" => "col-lg-8"]) ?>

                <?= div("+ agregar nota", ["class" => "col-lg-12 cursor_pointer text_agregar_nota", "onclick" => "agregar_nota();"]) ?>
                <?= get_btw(
                    div("NOTAS", ["class" => "strong col-lg-12"]),
                    textarea(["name" => "comentarios"], 1),
                    "input_notas"
                ) ?>
                <?= input_hidden(["name" => "punto_encuentro", "class" => "punto_encuentro_form"]) ?>
                <?= input_hidden(["name" => "num_ciclos", "class" => "num_ciclos", "value" => $num_ciclos]) ?>
                <?= br() ?>
                <?= guardar("CONTINUAR", ["class" => "top_20"]) ?>
                <?= get_formar_usuario_registrado($in_session, $servicio, $num_ciclos) ?>
                <?= form_close() ?>
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