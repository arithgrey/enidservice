"use strict";
let $selector_carga_modal = $('#stock_servicio_modal');
let $form_stock_servicio = $('.form_stock_servicio');
let $input_stock =  $form_stock_servicio.find('.stock');
let $input_id_servicio =  $form_stock_servicio.find('.id_servicio');
$(document).ready(() => {

    $(".form_compras").submit(busqueda);

});
let busqueda = (e) => {

    let data_send = $(".form_compras").serialize() + "&" + $.param({"v": 1});
    let url = "../q/index.php/api/stock/compras/format/json/";
    request_enid("GET", data_send, url, response_busqueda, ".place_compras");
    e.preventDefault();
};
let response_busqueda = data => {

    render_enid(".place_compras", data);
    $('.comparativas').click(busqueda_comparativa);
    $('.stock_disponible').click(editar_stock_disponible);
};
let editar_stock_disponible = function () {
    desbloqueda_form('.form_stock_servicio');
    let $id = get_parameter_enid($(this), "id");
    let $total = get_parameter_enid($(this), "total");
    $input_id_servicio.val($id);
    if (parseInt($id) > 0 ) {

        $selector_carga_modal.remove('d-none');
        $selector_carga_modal.modal("show");
        $input_stock.val($total);
        $form_stock_servicio.submit(stock_servicio);
    }
};

let stock_servicio = function(e){

    let data_send = $form_stock_servicio.serialize();
    let url = "../q/index.php/api/servicio/stock/format/json/";
    bloquea_form('.form_stock_servicio');
    request_enid("PUT", data_send, url, response_form_stock);
    e.preventDefault();
};
let response_form_stock = function (data) {

    $selector_carga_modal.modal("hide");
    $(".form_compras").submit();

};
let busqueda_comparativa = function (e) {

    let $id = get_parameter_enid($(this), "id");
    let $tabla_comprativa = $('.tabla_comprativa');
    for (let $a in $tabla_comprativa) {

        let current_id = parseInt($tabla_comprativa[$a].id);
        if (current_id == $id) {
            $tabla_comprativa[$a].classList.remove('d-none');
            modal($tabla_comprativa[$a]);
        }
    }

};