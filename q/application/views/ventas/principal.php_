<?php
    $lista_proyectos = "";
    foreach ($proyectos as $row) {

        //$id_proyecto     = $row["id_proyecto"];
        //$proyecto        = $row["proyecto"];
        //$descripcion     = $row["descripcion"];
        //$fecha_registro  = $row["fecha_registro"];
        //$url             = $row["url"];
        //$status          = $row["status"];
        $url_img = $row["url_img"];


        $item = anchor_enid(
            img(
                ["src" => $url_img,
                    "style" => 'width: 100%; height:150px;'
                ]),
            [
                "href" => $url, "target" => 'black'
            ]);
        $lista_proyectos .= div($item, ["class" => 'col-lg-3']);

    }
?>

<?= $lista_proyectos; ?>
