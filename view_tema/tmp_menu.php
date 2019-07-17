<?php


$estrellas = str_repeat(span('★', ["class" => "estrella", "style" => "color: #0070dd;"]), 4);

$estrellas .= span('★',
    [
        "class" => "estrella",
        "style" => "-webkit-text-fill-color: white;-webkit-text-stroke: 0.5px rgb(0, 74, 252);"]);

$li = [
    "",
    $menu,
    a_enid(
        "Mis reseñas y valoraciones" .
        d($estrellas, ["class" => "contenedor_promedios"]),
        ["href" => "../recomendacion/?q=" . $id_usuario]
    ),
    a_enid("Configuración y privacidad", ["href" => path_enid("administracion_cuenta") ]),
    a_enid("Cerrar sessión", ["href" => path_enid("logout")])
];

?>

<div class="text-right d-flex flex-row">
    <li class="dropdown  menu_notificaciones_progreso_dia">
        <?php $class_notificacion = ($is_mobile > 0) ? " notificaciones_enid_mb " : " notificaciones_enid "; ?>
        <?= a_enid(
            btw(icon("fa fa-bell white"), d("", "num_tareas_dia_pendientes_usr"), "display_flex_enid"),
            [
                "class" => "blue_enid dropdown-toggle",
                "data-toggle" => "dropdown"
            ]
        ) ?>
        <?= ul(
            [
                    place("place_notificaciones_usuario padding_10 shadow border")],
            "dropdown-menu shadow " . $class_notificacion
        ) ?>
    </li>

    <li class="dropdown ">
        <?= get_img_usuario($id_usuario) ?>
        <?= ul(
            $li,
             "dropdown-menu menu_usuario "
        ) ?>
    </li>
</div>