<div class="col-lg-6 col-lg-offset-3">
    <?= div(div("TIPO CLASIFICACIÓN"), 3) ?>
    <?= append_data(
        [
            form_open("", ["class" => "form-tipo-talla"]),
            input(["type" => "text", "name" => "tipo_talla", "required" => true]),
            form_close()
        ], 1, 9
    ) ?>
</div>
<?= place("place_tallas") ?>
