"use strict";
let $form_busqueda = $(".form_busqueda_pedidos");
let $ids = $(".ids");
let $usurios = $(".usuarios");
let $form_pago_comisiones = $('.form_pago_comisiones');
let $modal_pago_comision = $('#modal_pago_comision');
let $usuario_pago = $('.usuario_pago');
let $fecha_inicio = $form_pago_comisiones.find('.fecha_inicio');
let $fecha_termino = $form_pago_comisiones.find('.fecha_termino');

$(document).ready(() => {


    $('footer').ready(function () {
        valida_busqueda_inicial();
    });
    $form_busqueda.submit(busqueda_pedidos);
    $form_pago_comisiones.submit(registro_pago);
    $('.usuario_venta_pago').click(busqueda_pago_pendiente);
});

let busqueda_pedidos = function (e) {

    let fecha_inicio = get_parameter("#datetimepicker4");
    let fecha_termino = get_parameter("#datetimepicker5");
    if (fecha_inicio.length > 8 && fecha_termino.length > 8) {

        let data_send = $form_busqueda.serialize();
        let url = "../q/index.php/api/recibo/pedidos/format/json/";
        request_enid("GET", data_send, url, response_pedidos, ".place_pedidos");

    }
    e.preventDefault();
};
let response_pedidos = function (data) {

    render_enid(".place_pedidos", data);

    $('.usuario_venta').click(busqueda_usuario_selector);


    $('th').click(ordena_tabla);
    $(".desglose_orden").click(function () {
        let recibo = get_parameter_enid($(this), "id");
        $(".numero_recibo").val(recibo);
        $(".form_search").submit();
    });


};
let valida_busqueda_inicial = function () {


    if (parseInt($ids.val()) > 0 && $usurios.val().length > 0) {


        $form_busqueda.submit();
    }


};
let busqueda_usuario_selector = function (e) {


    let id = e.target.id;
    if (parseInt(id) > 0) {

        $(".comisionista option[value='" + id + "']").attr("selected", true);
        let data_send = $(this).serialize();
        let url = "../q/index.php/api/tag_arquetipo/interes/format/json/";
        request_enid("POST", data_send, url, response_tag_arquetipo);
        $form_busqueda.submit();

    }

};
let busqueda_pago_pendiente = function (e) {

    let id = e.target.id;
    $modal_pago_comision.modal("show");
    let total_comisiones = get_parameter_enid($(this), "total_comisiones");
    let nombre_comisionista = get_parameter_enid($(this), "nombre_comisionista");

    let fecha_inicio = get_parameter_enid($(this), "fecha_inicio");
    let fecha_termino = get_parameter_enid($(this), "fecha_termino");

    $usuario_pago.val(id);
    $fecha_inicio.val(fecha_inicio);
    $fecha_termino.val(fecha_termino);

    let text_comisionista = d(_text_(nombre_comisionista), 'text-uppercase text-center mt-3');
    let text_totales = d(_text_('Total', total_comisiones), 'h2 text-center');

    render_enid('.resumen_pago_comisionista', _text_(text_comisionista, text_totales));


}
let registro_pago = function (e) {
    
    let data_send = $(this).serialize();
    let url = '../q/index.php/api/recibo/pago_recibos_comisiones/format/json/';
    request_enid("PUT", data_send, url, response_pagos);
    e.preventDefault();
}
let response_pagos = function () {

    $modal_pago_comision.modal("hide");
    redirect('');
}
