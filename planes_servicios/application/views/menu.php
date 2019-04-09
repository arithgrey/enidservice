<?= get_menu($is_mobile, $action) ?>
<?php $extra_estilos = ($action == 1) ? " display_none " : " "; ?>
<?= get_btw(
    heading_enid("TUS ARTÍCULOS MÁS VISTOS DE LA SEMANA", 3)
    ,
    get_top_ventas($top_servicios)
    ,
    "contenedor_top " . $extra_estilos


) ?>



