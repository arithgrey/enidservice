"use strict";
let $editar_fecha = $('.editar_fecha');
let $form_fecha_ingreso = $('.form_fecha_ingreso');
let $form_unidades_disponibles = $('.form_unidades_disponibles');
let $input_stock = $form_fecha_ingreso.find('.id_stock');
let $input_hora_fecha = $form_fecha_ingreso.find('.hora_fecha');
let $stock_unidades = $('.stock_unidades');
let $modal_form_calendario = $("#modal_form_calendario");
let $modal_unidades_disponibles = $('#modal_unidades_disponibles');
let $unidades_disponibles_select = $form_unidades_disponibles.find('.unidades');
let $input_stock_disponibilidad = $form_unidades_disponibles.find('.id_stock');

$(document).ready(function () {

    $editar_fecha.click(form_fecha);
    $stock_unidades.click(modifica_unidades_stock);
    $form_unidades_disponibles.submit(unidades_stock_stock);

});
let form_fecha = function (e) {

    let $id_stock = get_parameter_enid($(this), "id");
    let $fecha_registro = get_parameter_enid($(this), "fecha_registro");
    if (parseInt($id_stock) > 0) {

        $input_hora_fecha.val($fecha_registro);
        $input_stock.val($id_stock);
        $modal_form_calendario.modal("show");
        $form_fecha_ingreso.submit(fecha_ingreso);
    }


};
let modifica_unidades_stock = function (e) {

    let $unidades_disponibles = get_parameter_enid($(this), "unidades_disponibles");
    let $id = get_parameter_enid($(this), "id");

    $unidades_disponibles_select.find('option').remove();
    for (let x = 0; x <= 100; x++) {
        $unidades_disponibles_select.append(new Option(x, x));
    }

    $modal_unidades_disponibles.modal("show");
    let select = '.form_unidades_disponibles .unidades';
    $input_stock_disponibilidad.val($id);
    selecciona_valor_select(select, $unidades_disponibles);
};
let fecha_ingreso = function (e) {


    let url = "../q/index.php/api/stock/fecha_ingreso/format/json/";
    let data_send = $form_fecha_ingreso.serialize();
    bloquea_form('.form_fecha_ingreso');
    request_enid("PUT", data_send, url, response_fecha_ingreso);

    e.preventDefault();
};
let response_fecha_ingreso = function (data) {

    redirect('');
};
let unidades_stock_stock = function (e) {

    let $id_stock = $input_stock_disponibilidad.val();
    if (parseInt($id_stock) > 0) {
        let url = "../q/index.php/api/stock/descuento/format/json/";
        let data_send = $form_unidades_disponibles.serialize();
        bloquea_form('.form_unidades_disponibles');
        request_enid("PUT", data_send, url, response_unidades);
    }

    e.preventDefault();
};
let response_unidades = function (data) {

    redirect('');
};