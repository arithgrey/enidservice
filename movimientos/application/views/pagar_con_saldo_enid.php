<?= n_row_12() ?>
    <div class="col-lg-4 col-lg-offset-4">
        <div class="jumbotron">
            <?= heading("REALIZAR COMPRA") ?>
            <select style="width: 100%" class="form-control">
                <option class="de" id='de' value="1">
                    De saldo Enid Service $ <?= get_data_saldo($saldo_disponible) ?> MXN
                </option>
            </select>
            <?= d("Monto total:" . $recibo["saldo_pendiente"] . "MXN",
                ["style" => "color: blue;font-size: 2.2em;text-decoration: underline;"],
                1) ?>
            <?= d($recibo["resumen"], 1) ?>
            <?php if (get_data_saldo($saldo_disponible) >= $recibo["saldo_pendiente"]): ?>
                <?= d("CONTINUAR " . icon("fa fa-chevron-right"),
                    [
                        "class" => "btn_transfer",
                        "style" => "border-radius: 20px;background: black;padding: 10px;color: white;"
                    ]) ?>

            <?php else: ?>
                <?= d(d("AUN NO CUENTAS CON FONDOS SUFICIENES EN TU CUENTA",
                    ["style" => "border-radius:20px;background: black;padding:10px;color: white;"]),
                    ["style" => "width: 80%;margin: 0 auto;margin-top: 20px;"]) ?>

                <?= d(a_enid("Agregar saldo a tu cuenta",
                    ["href" => "?q=transfer&action=6"], 1, 1),
                    ["style" => "width: 80%;margin: 0 auto;margin-top: 20px;", "class" => "text-right"]) ?>

            <?php endif; ?>
        </div>
    </div>
<?= end_row() ?>