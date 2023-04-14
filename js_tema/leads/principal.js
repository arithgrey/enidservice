"use strict";
let $form_busqueda = $(".form_busqueda_pedidos");

$(document).ready(() => {

    $form_busqueda.submit(busqueda_pedidos);

});

let busqueda_pedidos = function (e) {

    let fecha_inicio = get_parameter("#datetimepicker4");
    let fecha_termino = get_parameter("#datetimepicker5");
    if (fecha_inicio.length > 8 && fecha_termino.length > 8) {

        let data_send = $form_busqueda.serialize() + "&" + $.param({ "historial": 1 });
        let url = "../q/index.php/api/recibo/pedidos/format/json/";
        request_enid("GET", data_send, url, response_pedidos, ".place_pedidos");

    }
    e.preventDefault();
};
let response_pedidos = function (data) {

    render_enid(".place_pedidos", data);

};