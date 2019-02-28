<section id="hero" class="imagen_principal">
    <div class="container">
        <div class="row top_50 bottom_50">
            <div class="col-lg-3">
                <div style="background: #000 !important;opacity: .85;padding: .1px;opacity: .8">
                    <?= heading_enid(
                        "SABER MAS SOBRE EVENTOS ESPECIALES",
                        3,
                        ["class" => "white strong"]
                    ); ?>
                    <?= $this->load->view("../../../view_tema/social_enid") ?>
                </div>
            </div>
        </div>
    </div>
</section>
<section style='background:#0012dd !important;'>
    <div class="container inner" id="direccion">
        <?= get_format_visitanos($ubicacion) ?>
        <?= format_direccion_map($ubicacion) ?>
        <?= get_form_contactar($ubicacion, $departamentos, $nombre, $email, $telefono) ?>
    </div>
</section>
<?= input_hidden(["value" => $ubicacion, "class" => "ubicacion"]) ?>