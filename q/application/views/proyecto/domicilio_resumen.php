<?= d(
    anchor_enid(icon("fa fa-pencil"),
        ["class" => "a_enid_blue editar_direccion_persona"]
    )
    ,
    "text-right"
    ,
    1
) ?>
<?= d(
    get_format_domicilio($info_envio_direccion)
) ?>
