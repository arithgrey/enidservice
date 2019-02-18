<?= heading_enid("TUS ARTÍCULOS EN VENTA", "2", ["class" => "titulo_articulos_venta"]) ?>
<div class="contenedor_busqueda_articulos">
    <?= div("BUSCAR ENTRE TUS ARTÍCULOS", ["class" => "col-lg-4"]); ?>
    <div class="col-lg-4">
        <select class="form-control" name="orden" id="orden">
            <?php $a = 1;
            foreach ($list_orden as $row): ?>
                <option value="<?= $a ?>">
                    <?= $row ?>
                </option>
                <?php $a++;endforeach; ?>
        </select>
    </div>
    <?= div(input([
        "id" => "textinput",
        "name" => "textinput",
        "placeholder" => "Nombre de tu producto o servicio",
        "class" => "form-control input-sm q_emp",
        "onkeyup" => "onkeyup_colfield_check(event);"
    ]),
        ["class" => "col-lg-4"]); ?>
</div>
<?= place("place_servicios")?>