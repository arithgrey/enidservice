<?= br(2) ?>
<div class="col-lg-10 col-lg-offset-1">
    <center>
        <?= heading_enid("Recibe nuestra ubicación", 2, ["class" => "strong"]) ?>
        <?= div("¿A través de qué medio?", ["class" => "text_selector"]) ?>
    </center>
</div>
<div class="col-lg-10 col-lg-offset-1">
    <div class="contenedor_eleccion">
        <?= div(icon("fa fa-envelope-o") . " CORREO", ["class" => "easy_select_enid cursor_pointer selector",
            "id" => 1]) ?>
        <?= div(icon("fa fa-whatsapp") . " WHATSAPP", ["class" => "easy_select_enid cursor_pointer selector"
            ,
            "id" => 2]) ?>
    </div>
</div>
<div class="contenedor_eleccion_correo_electronico">
    <div class="col-lg-6 col-lg-offset-3">
        <div class="contendor_in_correo top_20">
            <?= get_form_ubicacion($servicio) ?>
        </div>
    </div>
</div>
<div class="contenedor_eleccion_whatsapp">
    <div class="col-lg-6 col-lg-offset-3">
        <div class="contendor_in_correo top_20">
            <?= get_form_whatsapp($servicio) ?>
        </div>
    </div>
</div>
<form action="../contact/?w=1" method="post" class="form_proceso_compra">
    <?= input_hidden(["class" => "proceso_compra", "value" => 1, "name" => "proceso_compra"]) ?>
</form>