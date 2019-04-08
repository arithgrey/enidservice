<?= div(
    get_btw(

        heading_enid("Recibe nuestra ubicación", 2, ["class" => "strong"])
        ,

        div("¿A través de qué medio?", ["class" => "text_selector"])
        ,

        "text-center"
    ),
    10
    ,
    1
) ?>
<?= div(div(get_format_eleccion(), ["class" => "contenedor_eleccion"]), 6, 1) ?>
<?= div(div(div(get_form_ubicacion($servicio), ["class" => "contendor_in_correo top_20"]), 6, 1), ["class" => "contenedor_eleccion_correo_electronico"]) ?>
<?= div(div(div(get_form_whatsapp($servicio), ["class" => "contendor_in_correo top_20"]), 6, 1), ["class" => "contenedor_eleccion_whatsapp"]) ?>
<?= get_form_proceso_compra() ?>