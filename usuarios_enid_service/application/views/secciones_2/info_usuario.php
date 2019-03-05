<?php
$l = [
    li(anchor_enid("Miembros activos" . icon("fa fa-trophy"),
        [
            "href" => "#tab_usuarios_activos",
            "data-toggle" => "tab",
            "class" => "equipo_enid_service",
            "id" => '1'
        ]), ["class" => "active", "id" => "1"]),

    li(anchor_enid(
        "Bajas" . icon("fa fa-chevron-circle-down"),
        [
            "href" => "#tab_usuarios_baja",
            "data-toggle" => "tab",
            "class" =>
                "btn_solo_llamar_despues equipo_enid_service",
            "id" => '0'
        ])),
    li(place("place_num_agendados_llamar_despues"))
];

?>
<?= heading_enid("Equipo Enid Service", 3) ?>
<?= div(ul($l, ["class" => "nav nav-tabs"]), ["class" => "panel-heading"]) ?>
<?= div(append_data([
    guardar("Agregar nuevo",
        [
            "class" => "btn input-sm btn_nuevo_usuario",
            "data-toggle" => "tab",
            "href" => "#tab_mas_info_usuario"
        ]),
    place("usuarios_enid_service")
]),
    ["class" => "tab-pane active", "id" => "tab_usuarios_activos"]) ?>

