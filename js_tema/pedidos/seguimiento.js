"use strict";
let $notifica_entrega = $('.notifica_entrega');
let $selector_entrega = $('.selector_entrega');
let $saldo_cubierto = $('.saldo_cubierto');
let $form_notificacion_entrega_cliente = $('.form_notificacion_entrega_cliente');
let $form_confirmacion_entrega = $('.form_confirmacion_entrega');
let $form_otros = $('.form_otros');
let $selector_interes = $('.selector_interes');
let $form_articulo_interes = $('.form_articulo_interes_entrega');
let $selector_negacion = $('.selector_negacion');
$(document).ready(function () {
    valida_notificacion_pago();
    carga_productos_sugeridos();
    $notifica_entrega.click(notifica_entrega_cliente);
    $selector_entrega.click(confirma_entrega_cliente);
    $selector_interes.click(mas_articulos);
    $form_articulo_interes.submit(registro_articulo_interes);
});
let valida_notificacion_pago = () => {

    let proceso = get_parameter(".notificacion_pago");

    if (proceso == 1) {

        let text = "¿HAZ REALIZADO TU COMPRA?";
        $.confirm({
            title: text,
            content: '',
            type: 'green',
            buttons: {
                ok: {
                    text: "SI, QUIERO NOTIFICAR MI COMPRA",
                    btnClass: 'btn-primary',
                    keys: ['enter'],
                    action: function () {
                        notificar_compra();
                    }
                },
                cancel: function () {

                }
            }
        });
    }
};
let notificar_compra = () => {

    let recibo = get_parameter(".orden");
    let data_send = {recibo: recibo};
    let url = "../q/index.php/api/recibo/notificacion_pago/format/json/";
    request_enid("PUT", data_send, url, procesa_notificacion)
};
let procesa_notificacion = data => {

    let text = "RECIBIMOS LA NOTIFICACIÓN DE TU COMPRA!";
    $.confirm({
        title: text,
        content: '',
        type: 'green',
        buttons: {
            ok: {
                text: "RASTREA TU PEDIDO",
                btnClass: 'btn-primary',
                keys: ['enter'],
                action: function () {
                    redirect("");
                }
            }
        }
    });
};
let carga_productos_sugeridos = () => {

    let url = "../q/index.php/api/servicio/sugerencia/format/json/";
    let q = get_parameter(".qservicio");
    let data_send = {"id_servicio": q};
    request_enid("GET", data_send, url, response_carga_productos);
};
let response_carga_productos = data => {

    if (data["sugerencias"] == undefined) {
        $('.sugerencias_titulo').removeClass('d-none');
        $(".text_interes").removeClass("hidden");
        render_enid(".place_tambien_podria_interezar", data);
    }
};
let notifica_entrega_cliente = function () {

    $('#modal_notificacion_entrega').modal("show");
};
let confirma_entrega_cliente = function () {
    let data_send = $form_notificacion_entrega_cliente.serialize();
    let url = "../q/index.php/api/recibo/status/format/json/";
    request_enid("PUT", data_send, url, response_confirma_entrega_cliente);
}
let response_confirma_entrega_cliente = function (data) {

    if (data === true) {
        $form_confirmacion_entrega.addClass('d-none');
        $form_otros.removeClass('d-none');

    }
}
let mas_articulos = function () {

    $form_articulo_interes.removeClass('d-none');
    $selector_negacion.addClass('d-none');
}
let registro_articulo_interes = function (e) {
    debugger;
    let data_send = $(this).serialize();
    let url = "../q/index.php/api/tag_arquetipo/interes/format/json/";
    request_enid("POST", data_send, url, response_tag_arquetipo);
    e.preventDefault();
};
let response_tag_arquetipo = function (data) {

    let $recibo = $('.recibo').val();
    let data_send = $.param({'v': 1, 'id': $recibo});
    let url = "../q/index.php/api/recibo/registro_articulo_interes/format/json/";
    request_enid("PUT", data_send, url, response_otros);

};
let response_otros = function () {
    redirect(path_enid('entregas'));
}