<div class='contenedor_principal_enid'>
    <div class="col-lg-4 col-lg-offset-4">
        <?= heading_enid("TUS CUENTAS <br> CUENTAS BANCARIAS", 3) ?>
        <?php foreach ($cuentas_bancarias as $row): ?>
            <?php $resumen_clabe = get_resumen_cuenta($row["clabe"]); ?>

            <?= div(append_data(
                [
                    $row["nombre"],
                    icon("fa fa-credit-card "),
                    div($resumen_clabe)
                ]
            ), ["class" => "info_cuenta top_10"]) ?>

        <?php endforeach; ?>
        <?= guardar("Agregar cuenta " . icon("fa fa-plus-circle "),
            ["class" => "top_20"],
            1, 1, 0
            , "?q=transfer&action=1") ?>

        <?= heading_enid("TARJETAS DE CRÉDITO Y DÉBITO", 3) ?>
        <?php foreach ($tarjetas as $row): ?>
            <?= div(append_data([
                $row["nombre"],
                icon("fa fa-credit-card "),
                div(substr($row["numero_tarjeta"], 0, 4) . "********")

            ]), ["class" => "info_cuenta"]) ?>
        <?php endforeach; ?>
        <?= guardar("Agregar cuenta " . icon("fa fa-plus-circle "),
            ["class" => "top_20"],
            1, 1, 0
            , "?q=transfer&action=1&tarjeta=1") ?>
    </div>
</div>
