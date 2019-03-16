<?php
$beneficiario = get_campo($usuario, "nombre") . " " . get_campo($usuario, "apellido_paterno") . " " . get_campo($usuario, "apellido_materno");
$folio = $info_pago["q2"];
$monto = $info_pago["q"];
$concepto = "Saldo a cuenta Enid Service";
?>
<div class="contenedor_principal_enid">
    <?= addNRow(div(div(get_form_saldos($beneficiario, $folio, $monto, $concepto), ["class" => "text-right"]), ["class" => "boton_imprimir_orden"])) ?>
    <div class="contenedor_orden_pago">
        <div class='contenido_orden_pago'>
            <div class="info_orden_compra">
                <?= append_data(

                    [
                        div(img(
                                [
                                    'src' => "http://enidservice.com/inicio/img_tema/portafolio/oxxo-logo.png",
                                    'style' => "width:100px!important"
                                ]
                            ) . "ORDEN DE PAGO EN SUCURSALES OXXO"),

                        div($concepto . "Beneficiario" . $beneficiario . "Folio #" . $folio, ["style" => "background: #0000f5;padding: 5px;color: white;color: white;"]),
                        get_monto_pago($monto),
                        get_instruccion_pago()
                    ]) ?>
            </div>
        </div>
    </div>
</div>