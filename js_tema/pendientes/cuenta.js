"use strict";
let $edita_cuenta_pago = $(".edita_cuenta_pago");
let $modal_cuenta = $("#modal_cuenta");
let $cerrar_modal = $(".cerrar_modal");
let $form_cuenta = $(".form_cuenta");
let $solicitud_deposito = $(".solicitud_deposito");
let $ultima_orden_compra = $(".ultima_orden_compra");
let $monto = $(".monto");

$(document).ready(() => {


    $edita_cuenta_pago.click(marcar_cuentas_pagas); 
    $cerrar_modal.click(function(){
        $modal_cuenta.hide();
    });

    $form_cuenta.submit(cuenta_pago);
    $solicitud_deposito.click(solicitud_deposito);

});


let cuenta_pago = function (e) {


    let $data_send = $(this).serialize();
    let url = "../q/index.php/api/cuenta_banco/index/format/json/";
    $modal_cuenta.hide();
    advierte('Procesando', 1);
    bloquea_form("form_cuenta");
    request_enid("POST", $data_send, url, response_cuenta_pago);

    e.preventDefault();

}

let solicitud_deposito = function (e) {


    let $id_cuenta_pago = $form_cuenta.find(".id_cuenta_pago").val();
    let $id_usuario = $form_cuenta.find(".id_usuario").val();
    let $ultima_orden = $ultima_orden_compra.val();
    let $monto_solicitado = $monto.val();
    
    if (parseInt($monto_solicitado) > 1 ) {
        
        let $data_send = $.param({
        "id_cuenta_pago" : $id_cuenta_pago, 
        "id_usuario" : $id_usuario,  
        "ultima_orden_compra" : $ultima_orden, 
        "monto" : $monto_solicitado, 

        });

        let url = "../q/index.php/api/solicitud_retiro/index/format/json/";
        advierte('Procesando ...', 1);
        request_enid("POST", $data_send, url, response_cuenta_pago);

    }else{

        advierte('Aún no cuentas con saldo suficiente, realiza algunas ventas y regresa pronto');
    }
    

    e.preventDefault();

}

let response_cuenta_pago = function (data) {
    
    redirect("");

}

let marcar_cuentas_pagas = function () {


    $modal_cuenta.show();

}

