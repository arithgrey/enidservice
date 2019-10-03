"use strict";
$(document).ready(() => {

    $(".form_compras").submit(busqueda);

});
let busqueda = (e) => {

    let data_send = $(".form_compras").serialize() + "&" + $.param({"v": 1});
    let url = "../q/index.php/api/stock/compras/format/json/";
    request_enid("GET", data_send, url, r_busqueda, ".place_compras");

    e.preventDefault();
};
let r_busqueda = data => {

    render_enid(".place_compras", data);
};