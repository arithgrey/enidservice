<?php
$info_status = "";
foreach ($status_enid_service as $row){
    if($row["id_estatus_enid_service"] ==  $tipo ) {
        $info_status = strtoupper($row["nombre"]);
        break;
    }
}

$l ="";
foreach($compras as $row) {

    $saldo_cubierto                 =  $row["saldo_cubierto"];
    $fecha_registro                 =  $row["fecha_registro"];
    $status                         =  $row["status"];
    $monto_a_pagar                  =  $row["monto_a_pagar"];
    $num_email_recordatorio         =  $row["num_email_recordatorio"];
    $costo_envio_cliente            =  $row["costo_envio_cliente"];
    $id_usuario_venta               =  $row["id_usuario_venta"];
    $num_ciclos_contratados         =  $row["num_ciclos_contratados"];
    $id_usuario                     =  $row["id_usuario"];
    $precio                         =  $row["precio"];
    $costo_envio_vendedor           =  $row["costo_envio_vendedor"];
    $id_servicio                    =  $row["id_servicio"];
    $resumen_pedido                 =  $row["resumen_pedido"];


    $url_imagen =  "../imgs/index.php/enid/imagen_servicio/".$id_servicio;
    ?>
    <div
        class="popup-box chat-popup" id="qnimate"
        style="margin-top: 4px;">
        <div class="popup-head">
            <div class="popup-head-left pull-left">
                <?=img([
                    "src"     =>  $url_imagen,
                    "style"   =>  'width: 44px!important',
                    "onerror" =>  "this.src='../img_tema/portafolio/producto.png'"
                ])?>
                <?=anchor_enid($resumen_pedido , ["href"=>"../producto/?producto=".$id_servicio])?>
                <?=div(append_data(["PRECIO" , $monto_a_pagar ," MXN | COSTO DE ENVIO AL CLIENTE ",$costo_envio_cliente , "| COSTO DE ENVIO AL VENDEDOR " ,$costo_envio_vendedor ,"MXN"]))?>
                <?=div(["ARTICULOS SOLICITADOS " , $num_ciclos_contratados , "|" , "SALDO CUBIERTO" , $saldo_cubierto , "MXN"])?>
                <?=append_data([
                    "LABOR DE COBRANZA",
                    icon("fa fa-envelope"),
                    $num_email_recordatorio
                ])?>
                <?=div($fecha_registro)?>
            </div>
        </div>
    </div>
    <?php

}
?>
<?=heading_enid("SOLICITUDES", $info_status)?>
<?=$l;?>

<style type="text/css">
    .popup-box{
        border: 1px solid #b0b0b0;
        bottom: 0;
        right: 70px;
        width: 100%;
    }
    .round.hollow a {
        border: 2px solid #ff6701;
        border-radius: 35px;
        color: red;
        color: #ff6701;
        font-size: 23px;
        padding: 10px 21px;
        text-decoration: none;
        font-family: 'Open Sans', sans-serif;
    }
    .round.hollow a:hover {
        border: 2px solid #000;
        border-radius: 35px;
        color: red;
        color: #000;
        font-size: 23px;
        padding: 10px 21px;
        text-decoration: none;
    }
    .popup-box .popup-head {
        background-color: #fff;
        clear: both;
        color: #7b7b7b;
        display: inline-table;
        font-size: 21px;
        padding: 7px 10px;
        width: 100%;
        font-family: Oswald;
    }
    .bg_none i {
        border: 1px solid #ff6701;
        border-radius: 25px;
        color: #ff6701;
        font-size: 17px;
        height: 33px;
        line-height: 30px;
        width: 33px;
    }
    .bg_none:hover i {
        border: 1px solid #000;
        border-radius: 25px;
        color: #000;
        font-size: 17px;
        height: 33px;
        line-height: 30px;
        width: 33px;
    }

    .popup-head-left img {
        border: 1px solid #7b7b7b;
        border-radius: 50%;
        width: 44px;
    }
    .popup-messages-footer > textarea {
        border-bottom: 1px solid #b2b2b2 !important;
        height: 34px !important;
        margin: 7px;
        padding: 5px !important;
        border: medium none;
        width: 95% !important;
    }
    .popup-head-right .btn-group .dropdown-menu li a {
        font-size: 12px;
        padding: 3px 10px;
        color: #303030;
    }

</style>
