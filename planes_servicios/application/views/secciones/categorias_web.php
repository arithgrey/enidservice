<div class="contenedor_categorias_servicios">
    <?= heading_enid("GRUPO AL CUAL PERTENECE TU PRODUCTO", 3) ?>
    <?= anchor_enid(
        "CANCELAR",
        [
            "class" => "cancelar_registro",
            "style" => "color: white!important"
        ],
        1); ?>
    <?= hr() ?>
    <?= get_places() ?>
</div>