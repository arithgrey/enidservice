"use strict";
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