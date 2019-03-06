<?= form_open("", ["class" => "form_compras", "method" => "post"]) ?>
<div class="col-lg-6 col-lg-offset-3">
    <?= get_form_entrega() ?>
    <div class="col-lg-6">
        <?= div("FECHA REFERENCIA", ["class" => 'strong']) ?>
        <select name="tipo" class="form-control">
            <option value="1">
                -1 MES
            </option>
            <option value="3">
                -3 MESES
            </option>
            <option value="6">
                -6 MESES
            </option>
            <option value="12">
                - 1 AÑO
            </option>
        </select>
    </div>
</div>
<?= form_close(place("place_compras")) ?>
