<?= n_row_12() ?>
    <div class="col-lg-4 col-lg-offset-4">
        <div class="jumbotron">
            <?= heading("REALIZAR COMPRA") ?>

            <select style="width: 100%" class="form-control">
                <option class="de" id='de' value="1">
                    De Pasaldo Enid Service $ <?= get_data_saldo($saldo_disponible) ?> MXN
                </option>
            </select>

            <div>
                <?= div("Monto total:" . $recibo["saldo_pendiente"] . "MXN",
                    ["style" => "color: blue;font-size: 2.2em;text-decoration: underline;"],
                    1) ?>
                <?= div($recibo["resumen"], 1) ?>
            </div>
            <?php if (get_data_saldo($saldo_disponible) >= $recibo["saldo_pendiente"]): ?>
                <?= div("CONTINUAR " . icon("fa fa-chevron-right"),
                    [
                        "class" => "btn_transfer",
                        "style" => "border-radius: 20px;background: black;padding: 10px;color: white;"
                    ]) ?>

            <?php else: ?>
                <?= div(div("AUN NO CUENTAS CON FONDOS SUFICIENES EN TU CUENTA",
                    ["style" => "border-radius:20px;background: black;padding:10px;color: white;"]),
                    ["style" => "width: 80%;margin: 0 auto;margin-top: 20px;"]) ?>

                <?= div(anchor_enid("Agregar saldo a tu cuenta",
                    ["href" => "?q=transfer&action=6"], 1, 1),
                    ["style" => "width: 80%;margin: 0 auto;margin-top: 20px;", "class" => "text-right"]) ?>

            <?php endif; ?>
        </div>
    </div>
<?= end_row() ?>