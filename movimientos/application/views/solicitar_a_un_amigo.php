<div class="col-lg-4 col-lg-offset-4">
    <?= heading("SOLICITA SALDO A UN AMIGO", 3) ?>
    <?= div(
        "Ingresa el monto y correo que solicitas a tu amigo para contar con saldo en tu cuenta."
        ,
        "desc_solicitud"
    ) ?>
    <?= form_open("", ["class" => 'solicitar_saldo_amigo_form']) ?>
    <table>
        <tr>
            <?= get_td(input([
                "placeholder" => "Ejemplo 200",
                "type" => "number",
                "name" => "monto",
                "class" => "form-control input-sm input monto_a_ingresar",
                "required" => true
            ]))
            ?>
            <?= get_td("MXN", "strong top_10" ) ?>
        </tr>
        <tr>
            <?= get_td("¿MONTO?",
                [
                    "colspan" => 2,
                    "style" => "color: black;text-decoration: underline;font-size: 2em;"]
            ) ?>
        </tr>
        <tr>
            <?= get_td(input([

                "type" => "email",
                "name" => "email_amigo",
                "class" => "form-control input-sm input email_solicitud",
                "placeholder" => "Ejemplo jmedrano@enidservice.com",
                "required" => true
            ])) ?>
            <?= get_td("Email", 'strong') ?>
        </tr>
    </table>
    <?= guardar("SOLICITAR SALDO", ["class" => "btn_solicitud_saldo"]) ?>
    <?= form_close(place("place_solicitud_amigo")) ?>
</div>
