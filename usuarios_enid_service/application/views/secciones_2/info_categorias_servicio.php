<div class="col-lg-7">
    <?= form_open("", ["class" => "form-horizontal form_categoria", "id" => "form_categoria"]) ?>
    <div class="form-group">
        <?= div("¿ES SERVICIO?", 4) ?>
        <div class="col-lg-8">
            <select id="servicio" name="servicio" class="form-control servicio">
                <option value="0">NO</option>
                <option value="1">SI</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <?= div("CATEGORÍA", 4) ?>
        <?= div(input([
            "id" => "textinput",
            "name" => "clasificacion",
            "placeholder" => "CATEGORÍA",
            "class" => "form-control input-md clasificacion",
            "required" => "true",
            "type" => "text"
        ]), 8) ?>
    </div>
    <?= get_btw(
        guardar("SIGUIENTE", ["class" => "a_enid_blue add_categoria"]),
        place("msj_existencia"),
        "form-group"
    ) ?>

    <?= form_close() ?>
    <table>
        <?= get_td(place('primer_nivel')) ?>
        <?= get_td(place('segundo_nivel')) ?>
        <?= get_td(place('tercer_nivel')) ?>
        <?= get_td(place('cuarto_nivel')) ?>
        <?= get_td(place('quinto_nivel')) ?>
    </table>
</div>
<?= div(heading("CATEGORÍAS 	EN PRODUCTOS Y SERVICIOS", 3), 5) ?>
