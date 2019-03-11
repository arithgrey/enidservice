<?= heading_enid("# Resultados " . count($info_tickets), 3) ?>
<?php
$l = "";
$estilos_estra = "";
foreach ($info_tickets as $row) {

    $id_ticket = $row["id_ticket"];
    $asunto = $row["asunto"];
    $id_usuario = $row["id_usuario"];
    $fecha_registro = $row["fecha_registro"];
    $nombre_departamento = $row["nombre_departamento"];
    $num_tareas_pendientes = $row["num_tareas_pendientes"];


    $tareas_pendientes = [
        "class" => 'strong white ver_detalle_ticket a_enid_black_sm',
        "id" => $id_ticket
    ];

    $id_usuario = $row["id_usuario"];
    $img_cliente = "../imgs/index.php/imagen_usuario/" . $id_usuario;
    $url_imagen = "../imgs/index.php/enid/imagen_usuario/" . $id_usuario;
    $btn_agregar_servicios = "";

    ?>
    <div class="popup-box chat-popup" id="qnimate">
        <div class="popup-head">
            <div class="popup-head-left pull-left">
                <?= get_img_usuario($id_usuario) ?>
                <?= div($asunto) ?>
                <?= div("#Tareas pendientes:" . $num_tareas_pendientes,
                    $tareas_pendientes,
                    ["class" => "cursor_pointer"]) ?>
            </div>
            <div class="dropdown pull-right">
                <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
                    <?= icon("fa fa-plus") ?>
                </button>
                <?= div(anchor_enid("CERRAR TICKET",
                    [
                        "class" => "cerrar_ticket",
                        "onClick" => "cerrar_ticket({$id_ticket})"
                    ]), ["class" => "dropdown-menu acciones_ticket"]); ?>
            </div>
        </div>
    </div>
    <?php
}
?>