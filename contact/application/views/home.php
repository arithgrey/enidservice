<section class="imagen_principal">
    <div class="col-lg-3 top_50">
        <div class="saber_mas">
            <?= heading_enid(
                "SABER MAS",
                3,
                ["class" => "white strong "]
            ); ?>
            <?= $this->load->view("../../../view_tema/social_enid") ?>
        </div>
    </div>
    <?= div("", 9) ?>
</section>

<?= div(format_direccion($ubicacion, $departamentos, $nombre, $email, $telefono), ["class" => "padding_15 top_100 bottom_100  blue_enid3   text-uppercase container inner", "id" => "direccion"]) ?>
<?= input_hidden(["value" => $ubicacion, "class" => "ubicacion"]) ?>