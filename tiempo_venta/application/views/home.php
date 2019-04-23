<?php

$r[] = form_open("", ["class" => "form_tiempo_entrega", "id" => "form_tiempo_entrega"]);
$r[] = div(

    div(input(

        [
            "name" => "q",
            "placeholder" => "id, nombre",
            "class" => "top_30 col-lg-12"
        ]
    ),12)

    ,
    4
);

$r[] =  div(get_format_fecha_busqueda(),8);


$r[] = form_close();
$form = div(append_data($r),1);
?>
<?=br(3)?>
<?= div(
    get_btw(
        div(heading_enid("ARTÍCULO", 3, ["class"=> "col-lg-12"]),1)
        ,
        $form
        ,
        8,1

    )
    ,
    13
) ?>




<?= div(place("place_tiempo_entrega"),8,1) ?>
