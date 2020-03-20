"use strict";
let $editar_fecha = $('.editar_fecha');
let $form_fecha_ingreso = $('.form_fecha_ingreso');
let $input_stock = $form_fecha_ingreso.find('.id_stock');
let $input_hora_fecha = $form_fecha_ingreso.find('.hora_fecha');
$(document).ready(function () {
    $editar_fecha.click(form_fecha);
});
let form_fecha = function (e) {

    let $id_stock = get_parameter_enid($(this), "id");
    let $fecha_registro = get_parameter_enid($(this), "fecha_registro");
    if (parseInt($id_stock) > 0) {

        $input_hora_fecha.val($fecha_registro);
        $input_stock.val($id_stock);
        $("#modal_form_calendario").modal("show");
        $form_fecha_ingreso.submit(fecha_ingreso);

    }

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
