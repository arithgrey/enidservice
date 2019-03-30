<div class="col-lg-4 col-lg-offset-4">
    <div class="jumbotron"
         style="background: #fbfbfb;border-right-style: solid;border-width:.9px;border-left-style: solid;">
        <?= heading("TRANSFERIR FONDOS", 2) ?>
        <div style="width: 80%;margin: 0 auto;margin-top: 20px;">
            <select style="width: 100%" class="form-control">
                <option class="de" id='de' value="1">
                    De saldo Enid Service $<?= get_data_saldo($saldo_disponible) ?> MXN
                </option>
            </select>
        </div>
        <div style="width: 80%;margin: 0 auto;margin-top: 20px;">
            <select style="width: 100%" class="form-control"
                <?= valida_siguiente_paso_cuenta_existente($cuentas_gravadas) ?> >
                <?php if ($cuentas_gravadas == 1): ?>
                    <?= despliega_cuentas_registradas($cuentas_bancarias) ?>
                <?php else: ?>
                    <option value="A">A
                    </option>
                <?php endif; ?>
            </select>
        </div>
        <?= get_format_cuentas_existentes($cuentas_gravadas) ?>
        <?= get_format_fondos($saldo_disponible) ?>
    </div>
</div>
