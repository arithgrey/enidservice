<?= n_row_12() ?>
    <div class='contenedor_principal_enid'>
        <div class="col-lg-4 col-lg-offset-4">
            <?= heading_enid("AÑADE SALDO A TU CUENTA DE ENID SERVICE AL REALIZAR ", 3) ?>
            <?= anchor_enid(get_btw(

                div("UN PAGO EN EFECTIVO EN OXXO ",
                    [
                        "class" => "tipo_pago",
                        "style" => "text-decoration: underline;color: black"
                    ],
                    1),

                div(
                    "Depositas 
						saldo a tu cuenta de Enid service desde  cualquier sucursal de oxxo ",
                    ["class" => "tipo_pago_descripcion"],
                    1),

                "option_ingresar_saldo tipo_pago"

            ), ["href" => "?q=transfer&action=7"]) ?>


            <?= anchor_enid(get_btw(

                div("SOLICITA SALDO A UN AMIGO",
                    [
                        "class" => "tipo_pago underline"
                    ]
                    ,
                    1
                ),

                div(
                    "Pide a un amigo que te transfira saldo desde su cuenta",
                    [
                        "style" => "text-decoration: underline;",
                        "class" => "tipo_pago_descripcion"
                    ]
                    ,
                    1),

                "option_ingresar_saldo"

            ), ["href" => "?q=transfer&action=9"]) ?>

        </div>
    </div>
<?= end_row() ?>