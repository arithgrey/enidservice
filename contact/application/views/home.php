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
        <?php if ($ubicacion == 1): ?>
            <div class="col-lg-6">
                <?= heading("VISÍTANOS!", 1, ["class" => "white"]) ?>
                <?= br() ?>
                <?= heading(
                    "Eje Central Lázaro Cárdenas 38, Centro Histórico C.P. 06000 CDMX, local número 406",
                    4,
                    ["class" => "white"
                    ]) ?>
            </div>
        <?php endif; ?>
        <div class="col-lg-6">
            <?php if ($ubicacion == 0): ?>
                <?= heading(
                    "Eje Central Lázaro Cárdenas 38, Centro Histórico C.P. 06000 CDMX, local número 406",
                    4,
                    ["class" => "white"
                    ]) ?>
            <?php endif; ?>
            <?= iframe([
                "src" => "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3762.556617993217!2d-99.14322968509335!3d19.431554086884976!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTnCsDI1JzUzLjYiTiA5OcKwMDgnMjcuOCJX!5e0!3m2!1ses!2s!4v1489122764846",
                "width" => "100%",
                "height" => "380"


            ]) ?>
        </div>
        <?php if ($ubicacion == 0): ?>
            <div class="col-lg-6">
                <?=get_form_contactar($departamentos, $nombre, $email, $telefono)?>
            </div>
        <?php endif; ?>
</section>
<?= input_hidden(["value" => $ubicacion, "class" => "ubicacion"]) ?>