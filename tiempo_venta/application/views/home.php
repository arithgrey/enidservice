<?php

$r[] = form_open("", ["class" => "form_tiempo_entrega", "id" => "form_tiempo_entrega"]);
$r[] = div(
    input(
        [
            "name" => "q",
            "placeholder" => "id, nombre"
        ]
    )
);

$r[] = form_close();
$form = append_data($r);
?>

<?= div(
    get_btw(
        heading_enid("ARTÍCULO", 3, ["clas" => "align-self-center"])
        ,
        $form
        ,
        "col-lg-4  offset-4 d-flex align-items-center justify-content-between"

    )
    ,
    13
) ?>




<?= div(place("place_tiempo_entrega"),8,1) ?>
