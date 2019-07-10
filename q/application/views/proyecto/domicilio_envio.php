<?php

$id_recibo = $param["id_recibo"];
$id_codigo_postal = 0;
$direccion = "";
$calle = "";
$entre_calles = "";
$numero_exterior = "";
$numero_interior = "";
$cp = "";
$asentamiento = "";
$direccion_envio = "";
$municipio = "";
$estado = "";
$flag_existe_direccion_previa = 0;
$pais = "";
$direccion_visible = "style='display:none;'";
$nombre_receptor = "";
$telefono_receptor = "";
foreach ($info_envio_direccion as $row) {

    $direccion = $row["direccion"];
    $calle = $row["calle"];
    $entre_calles = $row["entre_calles"];
    $numero_exterior = $row["numero_exterior"];
    $numero_interior = $row["numero_interior"];
    $cp = $row["cp"];
    $asentamiento = $row["asentamiento"];
    $municipio = $row["municipio"];
    $estado = $row["estado"];
    $flag_existe_direccion_previa++;
    $direccion_visible = "";
    $id_codigo_postal = $row["id_codigo_postal"];
    $pais = "";
    $nombre_receptor = $row["nombre_receptor"];
    $telefono_receptor = $row["telefono_receptor"];
}


if ($registro_direccion == 0) {

    $nombre = get_campo($info_usuario, "nombre");
    $apellido_paterno = get_campo($info_usuario, "apellido_paterno");
    $apellido_materno = get_campo($info_usuario, "apellido_materno");
    $nombre_receptor = $nombre . " " . $apellido_paterno . " " . $apellido_materno;
    $telefono_receptor = get_campo($info_usuario, "tel_contacto");
}
?>



<?=
div(btw(
    heading_enid("DIRECCIÓN DE ENVÍO", 2, "letter-spacing-5")
    ,
    get_format_direccion_envio_pedido(
        $nombre_receptor,
        $telefono_receptor,
        $cp,
        $id_usuario,
        $entre_calles,
        $calle,
        $numero_exterior,
        $numero_interior,
        $direccion_visible,
        $asentamiento,
        $municipio,
        $estado,
        $id_recibo
    )
    ,
    "contenedor_informacion_envio top_30"

), 8, 1)
?>

