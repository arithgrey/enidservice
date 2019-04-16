<?php

$r[] = form_open("", ["class" => "form_tiempo_entrega", "id" => "form_tiempo_entrega"]);
$r[] = div(
    input(
        [
            "name" => "q",
            "placeholder" => "id, nombre"
        ]
    ),4
);

$r[] =  div(get_format_fecha_busqueda(),8);


$r[] = form_close();
$form = div(append_data($r),13);
?>

<?= div(
    get_btw(
        heading_enid("ARTÍCULO", 3)
        ,
        $form
        ,
        8,1

    )
    ,
    13
) ?>




<?= div(place("place_tiempo_entrega"),8,1) ?>
