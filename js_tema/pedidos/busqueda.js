"use strict";
let $form_busqueda = $(".form_busqueda_pedidos");
let $ids = $(".ids");
let $usurios = $(".usuarios");
$(document).ready(() => {

    $('footer').ready(function () {
        valida_busqueda_inicial();
    });
    $form_busqueda.submit(busqueda_pedidos);

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