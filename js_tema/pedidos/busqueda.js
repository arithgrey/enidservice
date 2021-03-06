"use strict";
let $form_busqueda = $(".form_busqueda_pedidos");
let $ids = $(".ids");
let $usurios = $(".usuarios");
let $reparto = $(".reparto");
let $es_busqueda_reparto = $form_busqueda.find('.es_busqueda_reparto');
let $form_pago_comisiones = $('.form_pago_comisiones');
let $modal_pago_comision = $('#modal_pago_comision');
let $modal_pago_comisiones = $('#modal_pago_comisiones');
let $usuario_pago = $('.usuario_pago');
let $fecha_inicio = $form_pago_comisiones.find('.fecha_inicio');
let $fecha_termino = $form_pago_comisiones.find('.fecha_termino');
let $input_busqueda = $form_busqueda.find('.input_busqueda');
let $tipo_orden = $form_busqueda.find('.tipo_orden');
let $nombre_usuario_venta = $('.nombre_usuario_venta');
let $marcar_cuentas_pagas = $('.marcar_cuentas_pagas');

let $sintesis = $('.sintesis');
let $marcar_pagos = $('.marcar_pagos');
let $ids_pagos = $('.ids_pagos');
$(document).ready(() => {

    $('footer').ready(function () {
        valida_busqueda_inicial();
    });
    $form_busqueda.submit(busqueda_pedidos);
    $form_pago_comisiones.submit(registro_pago);
    $('.usuario_venta_pago').click(busqueda_pago_pendiente);
    $input_busqueda.keyup(elimina_guienes);
    $nombre_usuario_venta.click(filtro_ordenes_vendedor);
    $marcar_pagos.click(marcar_pagos);
    $marcar_cuentas_pagas.click(marcar_cuentas_pagas);
});

let busqueda_pedidos = function (e) {

    let fecha_inicio = get_parameter("#datetimepicker4");
    let fecha_termino = get_parameter("#datetimepicker5");
    if (fecha_inicio.length > 8 && fecha_termino.length > 8) {


        let data_send = $form_busqueda.serialize();
        debugger;

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

    } else if (parseInt($es_busqueda_reparto.val()) > 0) {

        selecciona_valor_select('.form_busqueda_pedidos .tipo_orden', 2);
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
let elimina_guienes = function (e) {

    if (e.keyCode === 173) {
        let texto = this.value;
        texto = texto.replace(/-/g, '');
        this.value = texto;
    }
}
let paste_busqueda = function () {

    event.preventDefault();
    if (event.clipboardData) {
        let str = event.clipboardData.getData("text/plain");
        event.target.value = str.replace(/-/g, '');
    }
}
let filtro_ordenes_vendedor = function (e) {

    let $id = e.target.id;
    if (parseInt($id) > 0) {

        $('.linea_venta').addClass('d-none').removeClass('d-block');
        let linea = _text('.usuario_', $id);
        $(linea).removeClass('d-none');
        $sintesis.removeClass('selector');


        $('sintesis').removeClass('selector');
        let linea_selector = _text('.nombre_vendedor_sintesis_', $id);
        $(linea_selector).addClass('selector');

    }


}
let marcar_pagos = function () {

    $modal_pago_comisiones.modal("show");
}
let marcar_cuentas_pagas = function () {


    let data_send = $.param({'ids' : $ids_pagos.val()});
    let url = '../q/index.php/api/recibo/pago_recibos_comisiones_ids/format/json/';
    request_enid("PUT", data_send, url, response_pagos);
    e.preventDefault();


}
