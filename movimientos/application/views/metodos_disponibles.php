<?php
$nombre = get_campo($usuario, "nombre");
$apellido_paterno = get_campo($usuario, "apellido_paterno");
$apellido_materno = get_campo($usuario, "apellido_materno");
$nombre_persona = $nombre . " " . $apellido_paterno . " " . $apellido_materno;
$text_tipo_ingreso = ($banca == 0) ? "ASOCIAR CUENTA BANCARIA" : "ASOCIAR TARJETA DE DÉDITO O CRÉDITO";
?>
<div class='contenedor_principal_enid'>
    <?php if ($seleccion == 0): ?>
    <div class="col-lg-4 col-lg-offset-4"
         style="background: #fbfbfb;border-right-style: solid;border-width: .9px;border-left-style: solid;">
        <?= heading($text_tipo_ingreso, 3) ?>
        <?= div("Enid Service protege y garantiza la seguridad de la información de su cuenta bancaria. Nunca revelaremos su información financiera y, cada vez que inicie una transacción con esta cuenta bancaria, Enid Service se lo notificará por correo electrónico."
        ) ?>

        <form class="form_asociar_cuenta" method="POST" action="?action=4">
            <div class="page-header">
                <?php if ($error == 1): ?>
                    <?= div(
                        "SE PRESENTARON ERRORES AL ASOCIAR CUENTA, VERIFIQUE SU INFORMACIÓN ENVIADA",
                        ["style" => "background: #004bff; color: white;padding: 5px;"]) ?>
                <?php endif; ?>
                <?= div(heading($nombre_persona, 4), ["style" => "border-bottom-style: solid;border-width: 1px;"]) ?>
                <?= heading("1.- PAÍS", 4) ?>

                <select class="form-control" name="pais">
                    <option value="1">
                        México
                    </option>
                </select>
                <?= heading("2.- SELECCIONA TU BANCO", 4) ?>

                <?= create_select(
                    $bancos,
                    "banco",
                    "banco_cuenta",
                    "sel1",
                    "nombre",
                    "id_banco",
                    1) ?>

                <?php if ($banca == 0): ?>
                    <?= heading("3.-NÚMERO CLABE(18 dígitos)", 4) ?>
                    <?= input([
                        "class" => "form-control numero_tarjeta",
                        "id" => "input-1",
                        "name" => "clabe",
                        "placeholder" => "Número clabe de tu banco",
                        "required" => true,
                        "maxlength" => "18",
                        "minlength" => "18"
                    ]) ?>

                <?php else: ?>
                    <?= heading("4.- TIPO DE TARJETA ", 4) ?>
                    <?php

                    $opt = array(
                        "text" => "Débito",
                        "v" => 0
                    );
                    $opt = array(
                        "text" => "Crédito",
                        "v" => 1
                    );

                    ?>
                    <?= create_select($opt, "tipo_tarjeta", "form-control", "tipo_tarjeta", "text", "v") ?>
                    <?= heading("5.- NÚMERO DE TARJETA " . icon("fa fa-credit-card-alt"), 4) ?>
                    <?= input([
                        "class" => "form-control numero_tarjeta",
                        "id" => "input-1",
                        "name" => "numero_tarjeta",
                        "placeholder" => "Número de tarjeta",
                        "required" => true,
                        "minlength" => "16",
                        "maxlength" => "16"
                    ]) ?>

                <?php endif; ?>
                <?= input_hidden(["name" => "tipo", "value" => $banca]) ?>
                <?= guardar("ASOCIAR" . icon("fa fa-chevron-right")) ?>
                <?= div(p("Al asociar tu cuenta, podrás transferir tu saldo de 
                                    Enid Service a tu cuenta personal",
                        ["class" => "white"])
                    ,
                    ["style" => "margin-top: 35px;background: #213668;padding: 10px;"]
                ) ?>
            </div>
    </div>
    <?= form_close() ?>
</div>
<?php else: ?>
    <?= div(get_format_asociar_cuenta_bancaria(), ["class" => "col-lg-4 col-lg-offset-4 contenedor_asociar_cuenta"]) ?>
<?php endif; ?>
</div>


