"use strict";
$(document).ready(function () {


    $(".form_compras").submit(busqueda);

});
let busqueda = (e) => {

    let data_send = $(".form_compras").serialize() + "&" + $.param({"v": 1});
    let url = "../q/index.php/api/stock/compras/format/json/";
    request_enid("GET", data_send, url, response_busqueda, ".place_compras");

    e.preventDefault();
}
let response_busqueda = data => {

    render_enid(".place_compras", data);
}